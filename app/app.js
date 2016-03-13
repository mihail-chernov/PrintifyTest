'use strict';

var printify = angular.module('printify', []);

printify.config(function($routeProvider) {

  $routeProvider.
      when('/', {
        controller: 'ListController',
        templateUrl: 'app/views/list.html'
      }).
      when('/add-product', {
        controller: 'ProductController',
        templateUrl: 'app/views/product.html'
      });
});


