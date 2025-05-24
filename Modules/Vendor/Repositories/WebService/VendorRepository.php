<?php

namespace Modules\Vendor\Repositories\WebService;

use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\Section;
use Modules\Vendor\Entities\VendorDeliveryCharge;
use Modules\Vendor\Entities\VendorCategory;

class VendorRepository
{
    protected $section;
    protected $vendor;
    protected $deliveryCharge;
    protected $category;

    function __construct(Vendor $vendor, Section $section, VendorCategory $category, VendorDeliveryCharge $deliveryCharge)
    {
        $this->section = $section;
        $this->vendor = $vendor;
        $this->deliveryCharge = $deliveryCharge;
        $this->category = $category;
    }

    public function getAllSections()
    {
        $sections = $this->section->with([
            'vendors' => function ($query) {
                $query->active()->with([
                    'deliveryCharge' => function ($query) {
                        $query->where('state_id', '');
                    }
                ]);

                $query->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
                    return $q->whereHas('subbscription', function ($query) {
                        $query->active()->unexpired()->started();
                    });
                });

                $query->inRandomOrder();
            },
        ]);

        $sections = $sections->whereHas('vendors', function ($query) {
            $query->active();
            $query->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
                return $q->whereHas('subbscription', function ($query) {
                    $query->active()->unexpired()->started();
                });
            });
        })->active()->inRandomOrder()->take(10)->get();
        return $sections;
    }

    public function getAllVendorsCategories($request)
    {
        $categories = $this->category->active()->mainCategories();
        if ($request->flag) {
            $categories = $categories->whereHas('vendors.section', function ($query) use ($request) {
                $query->where('flag', $request->flag);
            });
            $categories = $categories->orWhereHas('childrenRecursive.vendors.section', function ($query) use ($request) {
                $query->where('flag', $request->flag);
            });
        }

        if ($request->state_id && config('setting.other.select_shipping_provider') == 'vendor_delivery') {
            $categories = $categories->whereHas('vendors.deliveryCharge', function ($query) use ($request) {
                $query->active()->where('state_id', $request->state_id);
            });
            $categories = $categories->orWhereHas('childrenRecursive.vendors.deliveryCharge', function ($query) use ($request) {
                $query->active()->where('state_id', $request->state_id);
            });
        }

        $categories = $categories->with([
            'vendors' => function ($query) use ($request) {
                $query->active();
                $query->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
                    return $q->whereHas('subbscription', function ($query) {
                        $query->active()->unexpired()->started();
                    });
                });
                if ($request->state_id && config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $query = $query->whereHas('deliveryCharge', function ($query) use ($request) {
                        $query->active()->where('state_id', $request->state_id);
                    });
                }

                $query->sorted();
            },
        ]);
        return $categories->orderBy('sort', 'asc')->get();
    }

    public function getAllVendors($request)
    {
        $vendors = $this->vendor->active();

        if (isset($request->flag) && $request->flag == 'restaurant')
            $vendors = $vendors->restaurant();
        elseif (isset($request->flag) && $request->flag == 'service')
            $vendors = $vendors->service();
        elseif (isset($request->flag) && $request->flag == 'shop')
            $vendors = $vendors->shop();

        /*$vendors = $vendors->with(['sections' => function ($query) use ($request) {
            $query->active();
            if ($request['section_id']) {
                $query->where('vendor_sections.section_id', $request['section_id']);
            }
        }]);*/

        $vendors = $vendors->with(['categories' => function ($query) use ($request) {
            $query->active();
            if ($request['category_id']) {
                $query->where('vendor_categories_pivot.vendor_category_id', $request['category_id']);
            }
        }]);

        $vendors = $vendors->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });

        if ($request->with_products == 'yes') {
            // Get Vendor Products
            $vendors = $vendors->with([
                'products' => function ($query) use ($request) {
                    $query->active();
                    $query = $this->returnProductRelations($query, $request);
                    $query->orderBy('products.id', 'DESC');
                },
            ]);
        }

        /*if ($request['section_id']) {
            $vendors->whereHas('sections', function ($query) use ($request) {
                $query->where('section_id', $request['section_id']);
            });
        }*/

        if ($request['category_id']) {
            $vendors->whereHas('categories', function ($query) use ($request) {
                $query->where('vendor_categories_pivot.vendor_category_id', $request['category_id']);
            });
        }

        if ($request['state_id']) {
            $vendors->with([
                'deliveryCharge' => function ($query) use ($request) {
                    $query->where('state_id', $request->state_id);
                }
            ]);
            $vendors->whereHas('deliveryCharge', function ($query) use ($request) {
                $query->where('state_id', $request->state_id);
            });
        }

        if ($request['search']) {
            $vendors->whereHas('translations', function ($query) use ($request) {

                $query->where('description', 'like', '%' . $request['search'] . '%');
                $query->orWhere('title', 'like', '%' . $request['search'] . '%');
                $query->orWhere('slug', 'like', '%' . $request['search'] . '%');
            });
        }

        return $vendors->sorted()->get();
    }

    public function getOneVendor($request)
    {
        $vendor = $this->vendor->active();
        $vendor = $vendor->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });
        return $vendor->find($request->id);
    }

    /*public function getDeliveryChargesByVendorByState($request)
    {
        $charge = $this->charge
            ->where('vendor_id', $request['vendor_id'])
            ->where('state_id', $request['state_id'])
            ->first();

        return $charge;
    }*/

    public function findById($id, $with = [])
    {
        $vendor = $this->vendor->active();
        if (!empty($with)) {
            $vendor =  $vendor->with($with);
        }
        $vendor = $vendor->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });
        return $vendor->find($id);
    }

    public function findVendorByIdAndStateId($id, $stateId)
    {
        $vendor = $this->vendor
            ->with(['companies' => function ($q) use ($stateId) {
                $q->active();
                $q->whereHas('deliveryCharge', function ($query) use ($stateId) {
                    $query->where('state_id', $stateId);
                });
                $q->has('availabilities');
            }]);

        $vendor = $vendor->when(config('setting.other.enable_subscriptions') == 1, function ($q) {
            return $q->whereHas('subbscription', function ($query) {
                $query->active()->unexpired()->started();
            });
        });

        $vendor = $vendor->whereHas('states', function ($query) use ($stateId) {
            $query->where('state_id', $stateId);
        });

        return $vendor->find($id);
    }

    public function returnProductRelations($model, $request = null)
    {
        return $model->with([
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'options',
            'images',
            'vendor',
            'subCategories',
            'addOns',
            'variants' => function ($q) {
                $q->with(['offer' => function ($q) {
                    $q->active()->unexpired()->started();
                }]);
            },
        ]);
    }

    public function getDeliveryPrice($stateId, $vendorId)
    {
        return $this->deliveryCharge::active()
            ->where('state_id', $stateId)
            ->where('vendor_id', $vendorId)
            ->value('delivery');
    }
}
