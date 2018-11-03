# Flow

[![Build Status](https://travis-ci.com/xu-li/flow.svg?branch=master)](https://travis-ci.com/xu-li/flow)

Flow is a business flow implementation.

## Why?

Often, we are faced with complex business rules. It can be easily verified if the processes and transitions can be visualized. Flow does that and more. 

## Features

- [Transition Events](https://github.com/xu-li/flow/blob/master/examples/01-events/index.php)
- Visualization - Using [symfony/workflow](https://symfony.com/doc/current/workflow/dumping-workflows.html)

## Core classes/interfaces

### ProcessInterface

Each process must implement ```ProcessInterface```. Each process implementation should avoid storing state. The output of the ```proceed()``` method should only depend on the input ```payload```. 

### StrategyInterface

A ```StrategyInterface``` implementation decides which process from a number of possible processes should be picked.

### Flow

The main Flow class. See [Examples](#examples).


## Examples

1. [Simple](https://github.com/xu-li/flow/blob/master/examples/00-simple/index.php)
2. [Listen to transition events](https://github.com/xu-li/flow/blob/master/examples/01-events/index.php)

## License
[MIT](https://opensource.org/licenses/MIT)
