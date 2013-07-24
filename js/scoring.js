'use strict';
angular.module('scoring', ['ngResource']).
    factory('Scoring',function ($resource) {
        //var Scoring = $resource('http://localhost\\:8088/tests/score.json',
        var Scoring = $resource('http://localhost\\:8088/api/friend/:call/:game',
            { apiKey: 'testUpdate'}, {
                update: { method: 'PUT' }
                //, filter: { method: 'POST'}
            }
        );

        Scoring.prototype.update = function (cb) {
            return Scoring.update({id: this._id.$oid},
                angular.extend({}, this, {_id: undefined}), cb);
        };

        Scoring.prototype.destroy = function (cb) {
            return Scoring.remove({id: this._id.$oid}, cb);
        };

        return Scoring;
    }).config(function ($routeProvider) {
        $routeProvider.
            when('/game/:game', {controller: ScoringCtrl, templateUrl: '/html/score.html'}).
            when('/add/:game', {controller: SetScoringCtrl, templateUrl: '/html/addscore.html'})
            .otherwise({redirectTo: '/'});
    });

function ScoringCtrl($scope, Scoring, $routeParams) {
    //$scope.scores = Scoring.query();
    $scope.scores = Scoring.get({call: "getScore", game: $routeParams.game});
}

function SetScoringCtrl($scope, Scoring, $routeParams) {
    //$scope.scores = Scoring.query();
    //$scope.scores = Scoring.get({call: "setScore", game: $routeParams.game});

    $scope.save = function () {
        console.log("save");
        Scoring.update({call: "setScore", game: $routeParams.game},$scope.form);
    }
}
