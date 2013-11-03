## Git Stars

### Github Repo Recommender System

Recommender system for Github repos, build on Laravel, for Portsmouth University Web Research unit

#### Requirements

* [Composer](http://getcomposer.org)

#### Installation

* Clone down: `git clone git@github.com:40thieves/git-stars.git`
* Create `git-stars` database
* Run `php artisan migrate`

#### Usage

To populate the DB, navigate to `/github/update`. This will fetch data from the Github API.

#### To-dos

* Github API pagination
* Understand what the fuck is going on with recommender algorithms
* Serve data from an endpoint
* Profit?
