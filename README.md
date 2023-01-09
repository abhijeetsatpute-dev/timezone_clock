# timezone_clock
Drupal timezone clock module

# CONTENTS OF THIS FILE

  - Introduction
  - Requirements
  - Installation
  - Configuration


## INTRODUCTION

Timezone Clock is a module that will provide and admin config form and
a custom block which can be places on all the page to show current time
for the timezone selected in admin config form.
It will also show the country and city configured in the config form.


## REQUIREMENTS

No special requirements.


## INSTALLATION

 * Install as you would normally install a contributed or custom Drupal module.
   See: https://www.drupal.org/node/895232 for further information.


## CONFIGURATION
 
 * Enable timezone_clock module in admin/modules.
 * Configure the timezone settings at admin/structure/timezone-clock/settings.
 * Place Timezone Clock Block in admin/structure/block


## KNOWN ISSUES

 * Time shows in a block will not get updated if user is on the same page for long time.
 * Reloading current page will not invalidate cache tags, so the time will be unchanged.
 * Time will get updated once user navigate to another page.