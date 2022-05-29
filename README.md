# Base Temporal PHP worker

This is minimal [Temporal]() PHP worker setup. To getting starter with Temporal please refer to their [documentation](https://docs.temporal.io/php/introduction/).

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
docker-compose up
```

Your worker is ready to execute commands!

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

And keep in mind that this file and variables in it will be loaded by default only if you using docker-compose to start the worker. [read more](https://docs.docker.com/compose/env-file/).

#### .rr.yaml && .rr.dev.yaml
This is the place for your [Roadrunner server](https://roadrunner.dev/) config. You can set different configs for your local machine in `.rr.dev.yaml`, and your production server at `.rr.dev`

[Read more about `.rr.yaml` options here](https://roadrunner.dev/docs/intro-config)

####

## TODO:

- Test
- Proper config instead of $_ENV
- DI container
- Activity configuration outside of workflow and inject it in