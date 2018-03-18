Sonata Annotation Bundle
============

Adds Annotations for Sonata Admin.

This bundle was greatly inspired by [IbrowsSonataAdminAnnotationBundle](https://github.com/ibrows/IbrowsSonataAdminAnnotationBundle)

[![Build Status](https://travis-ci.org/kunicmarko20/SonataAnnotationBundle.svg?branch=master)](https://travis-ci.org/kunicmarko20/SonataAnnotationBundle)
[![Coverage Status](https://coveralls.io/repos/github/kunicmarko20/SonataAnnotationBundle/badge.svg?branch=master)](https://coveralls.io/github/kunicmarko20/SonataAnnotationBundle?branch=master)

Documentation
-------------

* [Installation](#installation)
* [How to use](#how-to-use)
* [Annotations](#annotations)

## Installation

**1.**  Add dependency with composer

```bash
composer require kunicmarko/sonata-annotation-bundle
```

**2.** Register the bundle in your Kernel

```php
return [
    //...
    KunicMarko\SonataAnnotationBundle\SonataAnnotationBundle::class => ['all' => true],
];
```

## How to use

Instead of creating class for Admin it is enough to just add annotation
to your entity.

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
    /**
     * @Sonata\FormField()
     * @Sonata\ListField()
     * @Sonata\ShowField()
     * @Sonata\DatagridField()
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
}
```

Clear cache:

```bash
bin/console cache:clear
```

And you will see Admin appear in your admin panel.

## Annotations

Here I will show you all the annotations and all the options you can set.
All options are optional, you don't need to set anything, it is enough
just to use annotation.

### Admin

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use App\Controller\YourCRUDController;

/**
 * @Sonata\Admin(
 *     label="Category",
 *     managerType="orm",
 *     group="Category",
 *     showInDashboard=true,
 *     onTop=true,
 *     icon="<i class='fa fa-user'></i>",
 *     labelTranslatorStrategy="sonata.admin.label.strategy.native",
 *     labelCatalogue="App",
 *     controller=YourCRUDController::class,
 *     serviceId="app.admin.category"
 * )
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```

### FormField

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
    /**
     * @Sonata\FormField(
     *      type="",
     *      options={},
     *      fieldDescriptionOptions={}
     * )
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
}
```

### ShowField

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
    /**
     * @Sonata\ShowField(
     *      type="",
     *      fieldDescriptionOptions={}
     * )
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
}
```

### ListField

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
    /**
     * @Sonata\ListField(identifier=true) 
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Sonata\ListField(
     *      type="",
     *      fieldDescriptionOptions={},
     *      identifier=false
     * )
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
}
```

### DatagridField

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
    /**
     * @Sonata\DatagridField(
     *      type="",
     *      fieldDescriptionOptions={},
     *      filterOptions={},
     *      fieldType="",
     *      fieldOptions={}
     * )
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
}
```

### ListAction

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @Sonata\Admin("Category")
 *
 * @Sonata\ListAction("show")
 * @Sonata\ListAction("edit")
 * @Sonata\ListAction("delete")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```

### Route

Add custom routes to your admin class:

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use App\Controller\YourCRUDController;

/**
 * @Sonata\Admin(
 *     label="Category",
 *     controller=YourCRUDController::class
 * )
 *
 * @Sonata\Route(name="import", path="/import")
 * @Sonata\Route(name="notify", path="/notify")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```

This just registers a custom route, you have additional helper annotations
that we will mention in next sub sections. We mention one by one but you
can use them all at the same time if you want.

#### ActionButton

This will add button next to your add button in a list view.

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use App\Controller\YourCRUDController;

/**
 * @Sonata\Admin(
 *     label="Category",
 *     controller=YourCRUDController::class
 * )
 *
 * @Sonata\Route(name="import", path="/import")
 *
 * @Sonata\ActionButton("import_action_button.html.twig")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```


#### DashboardAction

This will add button to your dashboard block for this entity.

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use App\Controller\YourCRUDController;

/**
 * @Sonata\Admin(
 *     label="Category",
 *     controller=YourCRUDController::class
 * )
 *
 * @Sonata\Route(name="import", path="/import")
 *
 * @Sonata\DashboardAction("import_dashboard_button.html.twig")
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```

#### ListAction

We already mentioned this one but here we show you that you can also add custom
route. 

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use App\Controller\YourCRUDController;

/**
 * @Sonata\Admin(
 *     label="Category",
 *     controller=YourCRUDController::class
 * )
 *
 * @Sonata\Route(name="import", path="/import")
 *
 * @Sonata\ListAction("show")
 * @Sonata\ListAction("edit")
 * @Sonata\ListAction("delete")
 * @Sonata\ListAction(name="import", options={"template"="import_list_button.html.twig"})
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Category
{
}
```

