<?php
namespace DanLundgren\DlQrcodesgenerator\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class QRcodesGeneratorControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \DanLundgren\DlQrcodesgenerator\Controller\QRcodesGeneratorController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\DanLundgren\DlQrcodesgenerator\Controller\QRcodesGeneratorController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllQRcodesGeneratorsFromRepositoryAndAssignsThemToView()
    {

        $allQRcodesGenerators = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $qRcodesGeneratorRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $qRcodesGeneratorRepository->expects(self::once())->method('findAll')->will(self::returnValue($allQRcodesGenerators));
        $this->inject($this->subject, 'qRcodesGeneratorRepository', $qRcodesGeneratorRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('qRcodesGenerators', $allQRcodesGenerators);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
