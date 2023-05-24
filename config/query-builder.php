<?php

// return [

//     /*
//      * By default the package will use the `include`, `filter`, `sort`
//      * and `fields` query parameters as described in the readme.
//      *
//      * You can customize these query string parameters here.
//      */
//     'parameters' => [
//         'include' => 'include',

//         'filter' => 'filter',

//         'sort' => 'sort',

//         'fields' => 'fields',

//         'append' => 'append',
//     ],

//     /*
//      * Related model counts are included using the relationship name suffixed with this string.
//      * For example: GET /users?include=postsCount
//      */
//     'count_suffix' => 'Count',

//     /*
//      * By default the package will throw an `InvalidFilterQuery` exception when a filter in the
//      * URL is not allowed in the `allowedFilters()` method.
//      */
//     'disable_invalid_filter_query_exception' => false,

//     /*
//      * By default the package will throw an `InvalidSortQuery` exception when a sort in the
//      * URL is not allowed in the `allowedSorts()` method.
//      */
//     'disable_invalid_sort_query_exception' => false,

//     /*
//      * By default the package inspects query string of request using $request->query().
//      * You can change this behavior to inspect the request body using $request->input()
//      * by setting this value to `body`.
//      *
//      * Possible values: `query_string`, `body`
//      */
//     'request_data_source' => 'query_string',
// ];


return [
    'default_sort_direction' => 'asc',
    'allowed_includes' => [],
    'max_results' => 100,
    'exception_fallback' => env('QUERY_BUILDER_EXCEPTION_FALLBACK', false),
    'field_aliases' => [],
    'parsers' => [
        'include' => \Spatie\QueryBuilder\IncludeManipulators\IncludeManipulator::class,
        'append' => \Spatie\QueryBuilder\AppendManipulators\AppendManipulator::class,
        'filter' => \Spatie\QueryBuilder\Filters\FiltersExact::class,
        'sort' => \Spatie\QueryBuilder\Sorts\Sort::class,
        'fields' => \Spatie\QueryBuilder\Fields\Fields::class,
        'search' => \Spatie\QueryBuilder\Search\Search::class,
        'paginate' => \Spatie\QueryBuilder\Pagination\Pagination::class,
    ],
];