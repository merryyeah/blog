<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use \App\Services\DetectionService;

class IndexController extends BaseController {
    /**
     * @var DetectionService
     */
    private $detectionService;
    private $pageSize = 6;
    public function __construct() {
        $this->detectionService = new DetectionService();
    }

    public function index() {
        $data = $this->getShowData();
        $data['historyList'] = [];
        return view('index.index', $data);
    }

    protected function getShowData() {
        $detectList = $this->detectionService->getDetections();
        $ngList = $this->detectionService->getLastDetectList();
        $summeryInfo = $this->detectionService->getSummerInfo();
        $aiList = $this->detectionService->getNgList(10);
        return array(
            'detectList' => $detectList,
            'ngList' => $ngList,
            'summeryInfo' => $summeryInfo,
            'aiList' => $aiList,
        );
    }

    public function getData() {
        $parseData = new \App\Libs\ParseData\ParseData();
        $data = $parseData->getMainData();
        $this->detectionService->addDetections($data);
    }

    public function refresh() {
        $this->getData();
        $data = $this->getShowData();
        $detectList = $data['detectList'];
        $ngList = $data['ngList'];
        $summeryInfo = $data['summeryInfo'];
        $aiList = $data['aiList'];

        $centerView = view('widget.index.center', array('detectList' => $detectList));
        $centerHtml = response($centerView)->getContent();

        $noticeView = view('widget.index.notice', array('ngList' => $ngList));
        $noticeHtml = response($noticeView)->getContent();

        $summeryView = view('widget.index.summary', array('summeryInfo' => $summeryInfo));
        $summeryHtml = response($summeryView)->getContent();

        $aiView = view('widget.index.ai', array('aiList' => $aiList));
        $aiHtml = response($aiView)->getContent();

        $data = array(
            'centerHtml' => $centerHtml,
            'noticeHtml' => $noticeHtml,
            'summeryHtml' => $summeryHtml,
            'aiHtml' => $aiHtml
        );
        return response()->json($data);
    }

    public function searchHistory() {
        $params = $_POST;
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        $status = $params['status'];
        $page = $params['page'];

        list($historyList, $total) = $this->detectionService->searchHistory($startTime, $endTime, $status, $page, $this->pageSize);
        $pagination = new \App\Libs\Tool\PaginationTool($total, $this->pageSize, $page);

        $historyListChunk = array_chunk($historyList, 2);
        $historyView = view('widget.index.historyContent', array('historyListChunk' => $historyListChunk, 'pagination' => $pagination));
        $historyHtml = response($historyView)->getContent();

        return response()->json(array(
            'historyHtml' => $historyHtml
        ));
    }
}
