# Laravel Restive SDK

Restive SDK is a companion project to [Laravel Restive](https://github.com/laravel-restive/restive)

It provides a fluent builder that somewhat mimics Laravel's Query Builder.

e.g. 

        $aqb = new ApiQueryBuilder();
        $url = $aqb->where('id', 1)
            ->orWhere('id', 2)
            ->whereIn('id', [2,3,4])
            ->whereBetween('id', [3,4])
            ->orderBy('id', 'desc')
            ->crossJoin('user')
            ->select('id', 'name')->select('status')
            ->get();


It will produced URL fragments that follow the standard required for filtering/ordering etc, used by 
[Laravel Restive](https://github.com/laravel-restive/restive)

Documentation will be available soon.

``More to come``

