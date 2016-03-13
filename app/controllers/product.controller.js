'use strict';

printify.controller('ProductController',
        function ProductController($scope, $routeParams, Product) {
            $scope.init = function () {
                $.urlParam = function (name) {
                    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results) {
                        return results[1] || 0;
                    } else {
                        return 0;
                    }
                }
                var id = $.urlParam('id');
                if (id > 0) {
                    $.get(serverURL + '/loadImageInfo', {id: id}, function (data) {
                            data = $.parseJSON(data);
                            var obj = document.getElementById("pic1");
                            obj.src = data.imageData;
                            obj.style.left = data.x + 'px';
                            obj.style.top = data.y + 'px';
                            obj.width = data.width;
                    });
                } else {
                    var obj = document.getElementById("pic1");
                    obj.src = "/images/placeholder.jpg";
                    obj.width = 222;
                }
            },
                    $scope.saveData = function () {
                        var obj = document.getElementById("pic1");
                        var imageX = parseInt(obj.style.left + 0, 10);
                        var imageY = parseInt(obj.style.top + 0, 10);
                        var imageWidth = obj.offsetWidth;
                        var imageHeight = obj.offsetHeight;
                        var imageBase64 = obj.src;

                        var data = {'imageX': imageX, 'imageY': imageY, 'imageWidth': imageWidth, 'imageHeight': imageHeight, 'imageBase64': imageBase64};
                        $.post(serverURL + '/addProduct', data)
                                .success(function (json) {
                                    json = $.parseJSON(json);
                                    location.href = '#/';
                                })
                                .error(function () {
                                    alert("Error");
                                });
                        return;

                    }

        });

