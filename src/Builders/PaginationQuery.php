<?php

namespace GhoniJee\DxAdapter\Builders;

trait PaginationQuery
{

    public function requirePagination($skip, $take)
    {
        return $this->request->has($take) && $this->request->has($skip);
    }

    public function setNextPagePaginate()
    {
        $requestSkip = config('dx-adapter.request.skip');
        $requestTake = config('dx-adapter.request.take');

        if (!$this->requirePagination($requestSkip, $requestTake)) {
            return;
        }
        $skip = $this->request->$requestSkip;
        if ($skip > 0) {
            $this->request->merge([
                "page" => $this->request->$requestSkip / $this->request->$requestTake + 1
            ]);
        }
    }
}
