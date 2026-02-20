# Freedom Mobile Test Task

## Greetings
This is one of the most intresting test task I got.
Easy to describe, fun to solve. Enjoyed it very much.
Thank you!

## Trivia
Task description: https://docs.google.com/document/d/1Un4lsH2QSfpoXRnRRRxzzvIJSmxK0cQQ/edit
Symfony application, reverse-proxy for:
- php.net
- symfony.com

Application should allow to open
original websites as local deployed.
Navigation has to work localy as well.

Has to be:
- covered with unit/integration tests
- deployed with docker, kubernetis

## Solution Approach
The Application provides 2 routes to cover the futures.

First route is common to cary navigation and page loading requests.

Second route `_external` cary assets loading.

## Deploy
- clone the git repo
  ```git clone git@github.com:romvos-work/freemobile.test.git freemobile.test```

### Optional
add to the hosts file of your operating system:
- 127.0.0.1	sym.freemobile.local
- 127.0.0.1	php.freemobile.local

Nginx config has setup for these domains to treat symfony.com and php.net respectively by adding header `x-test-request`.
The header value is used to figure out the domain to be proxied.

Nevertheless, task description demand to use env constant to define the domain,
so the env has higher priority than header `x-test-request`.

### Docker
Docker Version: 27.5.0

Docker Compose Version: 2.32.3


- run docker containers

```docker compose up -d --build```

- install dependencies

```docker exec freemobile_back composer install```

### Run Tests
```docker exec freemobile_back php bin/phpunit --testdox```

### Kubernetis
WIP
