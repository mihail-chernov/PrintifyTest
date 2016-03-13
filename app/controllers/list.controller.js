'use strict';

printify.controller('ListController',
    function ListController($scope, $routeParams,Products) {
      $scope.updateProduct = function(id) {
          location.href = '#/add-product?id='+id;
      },
      
      Products.list(function(data) {
          if (data.status != 200) {
              alert("Error getting products from API!");
          } else {
              $scope.products = data.data;
          }
      },function() {});
});

