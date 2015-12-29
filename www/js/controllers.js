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
  '$auth',
  'globalConfig',
  function( $scope, $http, $auth, globalConfig ) {

    this.init = function() {
      $scope.passwordType = 'password';
    }

    $scope.passwordToggle = function() {
      if( $scope.passwordType === 'password' ) {
        $scope.passwordType = 'text';
      } else {
        $scope.passwordType = 'password';
      }
    };

    $scope.$on('socket:error', function (ev, data) {
      console.log(ev, data);
    });

    $scope.registerEmail = function() {
      $auth
        .submitRegistration( $scope.registerData )
        .then( function( resp ) {
          // handle success response
          console.log(resp);
        })
        .catch( function( resp ) {
          // handle error response
          console.log(resp);
        });
    };

    $scope.registerFacebook = function() {
      $auth.authenticate('facebook')
        .then(function(resp) {
          // handle success
          console.log(resp);
        })
        .catch(function(resp) {
          // handle errors
          console.log(resp);
        });
    };

    $scope.registerTwitter = function() {
      $auth.authenticate('twitter')
        .then(function(resp) {
          // handle success
          console.log(resp);
        })
        .catch(function(resp) {
          // handle errors
          console.log(resp);
        });
    };

    $scope.registerGoogle = function() {
      $auth.authenticate('google')
        .then(function(resp) {
          // handle success
          console.log(resp);
        })
        .catch(function(resp) {
          // handle errors
          console.log(resp);
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
