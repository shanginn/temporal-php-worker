# Base Temporal PHP worker

This is minimal [Temporal](https://temporal.io/) PHP worker setup.
To get starter with Temporal please refer to their [documentation](https://docs.temporal.io/php/introduction/).

Feel free to customize it to your needs. This is just a boilerplate!   

## Quickstart

First, start Temporal server. Easiest way to do this is to use their [docker-compose setup](https://github.com/temporalio/docker-compose):

```shell
git clone git@github.com:temporalio/docker-compose.git temporal-docker-compose
cd temporal-docker-compose
docker-compose up
```

Then clone this repo and docker-compose up it.

```shell
git clone git@github.com:shanginn/temporal-php-worker.git
cd temporal-php-worker
cp .env.example .env
make init
docker-compose up
```

Your worker is ready to execute commands!

To check the worker we will need [Temporal CLI](https://docs.temporal.io/tctl/).

Install it. Then run
```shell
tctl workflow start --tq=default -wt=BaseWorkflowInterface -i='{"prefix": "Ms."}'
# Started Workflow Id: a046d7f9-c36a-481d-8eac-0dc7cf9150cb, run Id: 090810b9-9a24-4ad2-99ea-fa580cc16d7c
```

_If you see `Failed to create SDK client` it means Temporal is not running,
or CLI is not able to connect_

If you see `Started Workflow` message it means that your Temporal instance is working.
However, it doesn't mean the worker is running properly.

To check that run
```shell
tctl workflow descid a046d7f9-c36a-481d-8eac-0dc7cf9150cb | grep status
# "status": "Completed",
```

If you see `"status": "Completed"` then life is good!

Great work!

## Worker structure

We have:

- Project root files
- contracts
- src
- tests
- util-src

Let's go over them one by one.

### Project root files

Here we have a lot of files, but we need all of them to maintain and use our worker:

#### .env.example
This is where your configuration lies. Please rename it to .env (`mv .env.example .env`) before using the project.

And keep in mind that this file and variables in it will be loaded by default only if you using docker-compose
to start the worker. [read more](https://docs.docker.com/compose/env-file/).

#### .rr.yaml && .rr.dev.yaml
This is the place for your [Roadrunner server](https://roadrunner.dev/) config.
You can set different configs for your local machine in `.rr.dev.yaml`, and your production server at `.rr.dev`

[Read more about `.rr.yaml` options here](https://roadrunner.dev/docs/intro-config)

#### .php-cs.php
[PHP code style fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) configuration file. Enforces same code style
for all project.

To run:
```shell
make fixcs
```

**CAUTION:** this config contains [@PHP80Migration:risky](https://cs.symfony.com/doc/ruleSets/PHP80MigrationRisky.html)
ruleset, please read carefully about them or disable if you not sure.

#### phpstan.neon
[PHPStan](https://github.com/phpstan/phpstan) config file. This is Static Analysis Tool.

If you get a lot of errors you could lower the `level` inside config.

To run:
```shell
make phpstan
```

#### phpunit.xml
Config for [phpunit](https://phpunit.de/) testing framework.

_Work in progress._

#### declarations.php
Here is the place for define your Workflow and Activity classes (not interfaces).
The worker will register them automatically. 

#### worker.php
This is the main program. Worker will preload classes from composer _autoload.php_ then
it will register all the declared Workflows and Activities.

Then in starts and waits for commands from Temporal.

#### Makefile
This is a simple set of useful commands that you can run like `phpstan` or `fixcs` or `shell`.

Run `make` to see all available commands:
```shell
Available commands:
  help           Show this help
  init           Init application
  up             Run containers
  down           Stop containers
  install        Run `composer install` inside the worker container
  update         Run `composer update` inside the worker container
  build          Build images
  shell          Run bash inside working container
  tests-worker   WORK IN PROGRESS: Run tests
  fixcs          Run PHP CodeStyle fix
  phpstan        Run Static Analysis (PHPStan)

```

### contracts
This is the place for you DTO's, VO's, Enums and interfaces that you might want to
use outside this worker.

> But why is this not inside src folder?

Great question. Simply put: you should not get attached to this folder. In the future
you want to make a composer package out of it and share it with interested PHP services.

#### BaseWorkflowInterface.php
You will use this interface to run the workflow from other services.

[Read more about workflows](https://docs.temporal.io/php/workflows)

#### Config.php
This is a Data Transfer Object example to pass a bunch of params to start the workflow.

> Note: I don't know state of things now, but in the past Temporal wasn't able to 
> deserialize `private` and `protected` properties, be aware of this.


### src
Finally! The code that will actually do all the work. Here we have:

#### src/Workflows
Your workflow folder :)

You can read more about workflows [here](https://docs.temporal.io/php/workflows)

#### src/Services
Folder for your activities.

> Ok, but why not call the folder Activities?

Yeah, I hear you. You can rename it if you want.

But in my practice `ActivityInterface` classes usually represent some service and
functions inside that classes represent the actions (activities) inside the service.

For me, it's just more logical to think about classes and functions in that paradigm.

[Read more about activities.](https://docs.temporal.io/php/activities)

### util-src
This is the place for all the utils, helpers, etc.

## TODO:

- Tests
- Proper config instead of $_ENV
- DI container
- Activity configuration outside of workflow and inject it in
