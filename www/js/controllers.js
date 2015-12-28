angular.module('now.controllers', [])

.controller('WelcomeCtrl', function($scope) {})

.controller('LoginCtrl', ['$scope', function($scope) {

  this.init = function() {

    $scope.loginData = {
      email: '',
      password: ''
    }
  };

  $scope.loginSubmit = function() {
    console.log( $scope.loginData.email );
    console.log( $scope.loginData.password );
  };

  this.init();
}])

.controller('RegisterCtrl', [
  '$scope',
  '$http',
  'globalConfig',
  function( $scope, $http, globalConfig ) {

    this.init = function() {

      $scope.registerData = {
        first: '',
        last: '',
        email: '',
        password: ''
      }
    };

    $scope.$on('socket:error', function (ev, data) {
      console.log(ev, data);
    });

    $scope.registerSubmit = function() {

      $http
        .post( globalConfig.url + '/register', $scope.registerData )
        .then( function( response ) {
          console.log('success');
          console.log(response);
        }, function( response ) {
          console.log('fail');
          console.log(response);
        });
    };

    this.init();
  }
])

.controller('DashCtrl', function($scope) {})

.controller('ChatsCtrl', function($scope, Chats) {
  // With the new view caching in Ionic, Controllers are only called
  // when they are recreated or on app start, instead of every page change.
  // To listen for when this page is active (for example, to refresh data),
  // listen for the $ionicView.enter event:
  //
  //$scope.$on('$ionicView.enter', function(e) {
  //});

  $scope.chats = Chats.all();
  $scope.remove = function(chat) {
    Chats.remove(chat);
  };
})

.controller('ChatDetailCtrl', function($scope, $stateParams, Chats) {
  $scope.chat = Chats.get($stateParams.chatId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  };
});
