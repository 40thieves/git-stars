## Git Stars

### Github Repo Recommender System

Recommender system for Github repos, built on Laravel, for Portsmouth University Web Research unit

#### Requirements

* [Composer](http://getcomposer.org)

#### Installation

* Clone down: `git clone git@github.com:40thieves/git-stars.git`
* Create `git-stars` database
* Run `php artisan migrate`
* `chmod -R 777 app/storage`

#### Usage

##### Dataset creation
To populate the DB, navigate to `/github`. This will request permission a Github OAuth token, then fetch data from the Github API. Note: it may take a long time for the API to return, so please be patient.

##### Recommendations
Once the dataset has been created, recommendations for repos can be generated when given a starting repo. This can be entered in the input box on the homepage or by navigating to `/recommend/STARTING_REPO_NAME`. A JSON response containing the top 5 recommended repos will be returned.

##### Example usage
Navigating to `/recommend/laravel` returns the following:

```json
{
	21: {
		id: 22,
		name: "Ratchet",
		language: null,
		url: "https://github.com/cboden/Ratchet",
		created_at: "2013-11-19 18:54:41",
		updated_at: "2013-11-19 18:54:41"
	},
	22: {
		id: 23,
		name: "react",
		language: null,
		url: "https://github.com/reactphp/react",
		created_at: "2013-11-19 18:54:41",
		updated_at: "2013-11-19 18:54:41"
	},
	102: {
		id: 103,
		name: "moment",
		language: null,
		url: "https://github.com/moment/moment",
		created_at: "2013-11-19 18:54:41",
		updated_at: "2013-11-19 18:54:41"
	},
	548: {
		id: 549,
		name: "laravel-ide-helper",
		language: null,
		url: "https://github.com/barryvdh/laravel-ide-helper",
		created_at: "2013-11-19 18:55:56",
		updated_at: "2013-11-19 18:55:56"
	},
	550: {
		id: 551,
		name: "sentry",
		language: null,
		url: "https://github.com/cartalyst/sentry",
		created_at: "2013-11-19 18:55:56",
		updated_at: "2013-11-19 18:55:56"
	}
}
```