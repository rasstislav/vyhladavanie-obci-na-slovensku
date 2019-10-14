<?php

namespace App\Http\Controllers;

use App\Models\SiteTree;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteTreeController extends Controller
{
    /**
     * @param  \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $builderOrRelation
     * @param  string  $slug
     * @return SiteTree
     *
     * @throws NotFoundHttpException
     */
    private function findSiteTree($builderOrRelation, string $slug): SiteTree
    {
        $siteTree = $builderOrRelation->whereRouteKey($slug)->firstOrFail(['id', 'page_id', 'page_type']);
        if (! $siteTree->page) {
            throw new NotFoundHttpException;
        }

        return $siteTree;
    }

    /**
     * Show the detail of page.
     *
     * @param  string  $slug
     * @return View
     */
    public function __invoke(string $slug)
    {
        $slugs = collect(array_filter(explode('/', $slug)));

        $siteTree = $slugs->reduce(function ($siteTree, $slug) {
            return $this->findSiteTree($siteTree->children(), $slug);
        }, $this->findSiteTree(SiteTree::root(), $slugs->shift()));

        if (! ($controller = config('site-tree.controllers.' . $siteTree->page_type))) {
            throw new NotFoundHttpException;
        }

        return app($controller)->__invoke($siteTree->page);
    }
}
