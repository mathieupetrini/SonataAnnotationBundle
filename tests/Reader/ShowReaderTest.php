<?php

declare(strict_types=1);

namespace KunicMarko\SonataAnnotationBundle\Tests\Reader;

use Doctrine\Common\Annotations\AnnotationReader;
use InvalidArgumentException;
use KunicMarko\SonataAnnotationBundle\Reader\ShowReader;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\AnnotationClass;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\AnnotationExceptionClass;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\AnnotationExceptionClass3;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\EmptyClass;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ShowReaderTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var ShowReader
     */
    private $showReader;
    private $showMapper;

    protected function setUp(): void
    {
        $this->showMapper = $this->prophesize(ShowMapper::class);
        $this->showReader = new ShowReader(new AnnotationReader());
    }

    public function testConfigureFieldsNoAnnotation(): void
    {
        $this->showMapper->add()->shouldNotBeCalled();
        $this->showReader->configureFields(
            new \ReflectionClass(EmptyClass::class),
            $this->showMapper->reveal()
        );
    }

    public function testConfigureFieldsAnnotationPresent(): void
    {
        $this->showMapper->add('field', Argument::cetera())->shouldBeCalled();
        $this->showMapper->add('method', Argument::cetera())->shouldBeCalled();
        $this->showMapper->add('parent.name', Argument::cetera())->shouldBeCalled();
        $this->showMapper->add('additionalField2', Argument::cetera())->shouldBeCalled();

        $this->showReader->configureFields(
            new \ReflectionClass(AnnotationClass::class),
            $this->showMapper->reveal()
        );
    }

    /**
     * @group legacy
     * @expectedDeprecation The "KunicMarko\SonataAnnotationBundle\Annotation\ParentAssociationMapping" annotation is deprecated since 1.1, to be removed in 2.0. Use KunicMarko\SonataAnnotationBundle\Annotation\AddChild instead.
     */
    public function testConfigureFieldsAnnotationException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument "field" is mandatory in "KunicMarko\SonataAnnotationBundle\Annotation\ShowAssociationField" annotation.');
        $this->showReader->configureFields(
            new \ReflectionClass(AnnotationExceptionClass::class),
            $this->showMapper->reveal()
        );
    }

    public function testConfigureFieldsAnnotationPresentPosition(): void
    {
        $mock = $this->createMock(ShowMapper::class);

        $propertiesAndMethods = ['parent.name', 'method', 'additionalField2', 'field'];
        $mock->expects($this->exactly(4))
            ->method('add')
            ->with($this->callback(static function (string $field) use (&$propertiesAndMethods): bool {
                $propertyAndMethod = array_shift($propertiesAndMethods);

                return $field === $propertyAndMethod;
            }));

        $this->showReader->configureFields(
            new \ReflectionClass(AnnotationClass::class),
            $mock
        );
    }

    /**
     * @group legacy
     */
    public function testPositionShouldBeUnique(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Position "1" is already in use by "field", try setting a different position for "field2".');
        $this->showReader->configureFields(
            new \ReflectionClass(AnnotationExceptionClass3::class),
            $this->showMapper->reveal()
        );
    }
}
