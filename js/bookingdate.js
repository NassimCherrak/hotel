      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.booking = [];
        $scope.booklist = [];

        $scope.bookingdate = [];
        $scope.bookdatelist = [];

        //search booking with date
        $scope.searchDate = function() {
          $scope.bookingdate = [];
          $scope.bookdatelist = [];
          $url = "include/date_booking.php?timein="+ formatDate($scope.datein) +"&timeout="+ formatDate($scope.dateout);
          console.log($url);
          $http.get($url)
            .then(function (response) {
              $scope.bookingdate = response.data.records;

              for(i=0;i<$scope.bookingdate.length;i++) {
                $scope.bookdatelist.push($scope.bookingdate[i]);
              }
            }, function (response) {
              console.log("couldn't load");
          });
        }

        });

        function formatDate(date) {
          var d = new Date(date),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

          if (month.length < 2) month = '0' + month;
          if (day.length < 2) day = '0' + day;

          return [year, month, day].join('-');
        }