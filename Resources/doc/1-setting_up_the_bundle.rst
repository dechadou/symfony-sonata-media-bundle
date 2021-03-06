Step 1: Setting up the bundle
=============================

A) Download the Bundle
----------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require mediamonks/sonata-media-bundle ~1.0

This command requires you to have Composer installed globally, as explained
in the `installation chapter`_ of the Composer documentation.

B) Enable the Bundle
--------------------

Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project:

.. code-block:: php

    // app/AppKernel.php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = [
                // ...
                new MediaMonks\SonataMediaBundle\MediaMonksSonataMediaBundle(),
            ];

            // ...
        }
    }

.. _`installation chapter`: https://getcomposer.org/doc/00-intro.md

C) Load routes
--------------

To make sure the images in the admin are resolved to the controller it is required to load the bundle routes by adding
the following lines to your app's routing.yml:

.. code-block:: yml

    // app/config/routing.yml
    _mediamonks_media:
        resource: "@MediaMonksSonataMediaBundle/Resources/config/routing.yml"
