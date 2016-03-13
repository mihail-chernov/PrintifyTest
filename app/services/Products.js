'use strict';

printify.factory('Products', function ($http) {
    return {
            list: function (onSuccess,onError) {
            return $http({
                url: '/api/server.php/list',
                method: "GET"
            }).then(onSuccess, onError);
        }
    }
});


