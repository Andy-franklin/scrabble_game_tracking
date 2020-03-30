# Provalido Scrabble

## Setup

install dependencies

```sh
composer install

npm install
```

build the styles/javascript

```sh
npm run dev
```

set your .env file to have the database connection

create the database and then run the migrations

(create the database manually)

```sh
php artisan migrate
```

run the development environment 🚀

```sh
php artisan serve
```

(run with xdebug)

```sh
php -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9000 -dxdebug.remote_host=127.0.0.1 artisan serve
```

##

Leaderboard page:

http://127.0.0.1:8000/leaderboard

Admin Members page (A members’ page including the following*):

http://127.0.0.1:8000/admin/members

Admin Games page (The ability to add scores for matches to the database*):

http://127.0.0.1:8000/admin/games



## The Challenge

A Scrabble Club requires a system to store members’ information and provide leader boards to show
their top performing players.

For the basic details of members, the requirement is to store information such as the date they
joined the Club, and their contact details. All recorded Scrabble games are head-to-head matches
between two players: the player with the higher score at the end of the game wins.

You should provide:
* A members’ page including the following (http://127.0.0.1:8000/admin/members)
    * Option to add a new member
    * Option to edit a member to update a members’ details.
    * Option to view a member’s profile screen
* A members’ profile screen showing (http://127.0.0.1:8000/member/{memberId})
    * number of wins.
    * number of losses.
    * their average score.
    * their highest score, when and where it was scored, and against whom.
* The ability to add scores for matches to the database (http://127.0.0.1:8000/admin/games)
* A leader board screen to list the members with the top 10 average scores, drawn only from
those members who have played at least 10 matches. (http://127.0.0.1:8000/leaderboard)
* Below the leader board, statistics showing the current highest and lowest scores achieved,
who scored them, against whom, and when.

There is no requirement for users to login or be authenticated.


### Issues

* pagination on the admin interface tables does not make another request and displays only the first page of data
