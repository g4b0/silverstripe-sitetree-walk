# SiteTree Walk

Implementation of the annoying task to walk through the entire SiteTree in order to do things over the pages.

## Introduction

This module by itself does not do anything, it just iterate recursively through the SiteTree and hooks every implementor
of SiteTreeWalkListener interface letting them doing things over each page.

## Requirements

 * SilverStripe 3.1

## Installation

Install the module through [composer](http://getcomposer.org):

	composer require --no-update zirak/sitetree-walk
	composer update --no-dev zirak/sitetree-walk

## Running the task.

Before running the task you need to implement your logic extending SiteTreeWalkListener interface. An example is provided 
with SiteTreeWalkPrint, that simply prints out the page title. Following the output of the sample:

```bash
#sake dev/tasks/SiteTreeWalk "flush=all"
Running Task SiteTreeWalk

Following SiteTreeWalkListener Implementors will be executed: 
	* SiteTreeWalkPrint

Continue? [y|n]y

Home 
Test 
	Test 2 
	Test 3 
Chi siamo 
Contattaci 
Pagina non trovata  *** Excluded from processing
Errore server  *** Excluded from processing
My Page 

################################################
Traversed Pages: 9

Processed Pages: 
	SiteTreeWalkPrint: 9
################################################
```
