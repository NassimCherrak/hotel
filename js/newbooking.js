      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.guests = [];
        $scope.guestlist = [];

        $scope.rooms = [];
        $scope.roomlist = [];

        $scope.showdateout = false;

        //load guest and room names to fill the select options
        $http.get("include/guests_rooms.php")
          .then(function (response) {
            $scope.guests = response.data.guestdata;
            $scope.rooms = response.data.roomdata;

            for(i=0;i<$scope.guests.length;i++) {
              $scope.guestlist.push($scope.guests[i]);
            }
            for(i=0;i<$scope.rooms.length;i++) {
              $scope.roomlist.push($scope.rooms[i]);
            }
          }, function (response) {
            console.log("couldn't load");
          });

        //checkbox to show/hide the option of the second date (date of the end of a booking)
        $scope.toggleShowDateOut = function() {
          $scope.showdateout = !$scope.showdateout;
          if(!$scope.showdateout) {
            $scope.dateout = "";
          }
        }

        //forces the minimum date of dateout to datein to avoid having dateout<datein
        $scope.updateMin = function(date) {
          $scope.formatedMin = formatDate(date);
          d1 = new Date($scope.datein);
          d2 = new Date($scope.dateout);
          if(d1>d2) {
            $scope.dateout = "";
          }
        }
        
        });
