<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Libs\Tool\CommonTool;
class DetectionService{
    private $okStatus = 'ok';

    public function __construct() {
    }

    public function getSummerInfo() {
        $total = DB::table('detection_log')->count('detection_log_id');
        $okCnt = DB::table('detection_log')->where('result', $this->okStatus)->count();
        $ngCnt = $total - $okCnt;
        $okRate = $total ? (round($okCnt / $total * 100, 2) . '%') : 0;
        return array(
            'total' => $total,
            'okCnt' => $okCnt,
            'ngCnt' => $ngCnt,
            'okRate' => $okRate
        );
    }

    public function getLastDetectList($pageSize = 4) {
        return DB::table('detection_log')->orderBy('detection_log_id', 'desc')->take($pageSize)->get()->toArray();
    }

    public function getNgList($pageSize = 4) {
        return DB::table('detection_log')->where('result', '!=', 'ok')->orderBy('detection_log_id', 'desc')->take($pageSize)->get()->toArray();
    }

    public function getDetections($pageSize = 1) {
        return DB::table('detection_log')->orderBy('detection_log_id', 'desc')->take($pageSize)->get()->toArray();
    }

    public function addDetections($detections) {
        $successCnt = 0;
        foreach ($detections as $detection) {
            $serialNo = $detection['serial_no'];
            $logInfo = $this->getDetectionLogInfo($serialNo);
            if ($logInfo) {
                continue;
            }

            $insert = array(
                'serial_no' => $detection['serial_no'],
                'time' => $detection['time'],
                'image' => $detection['image'],
                'image_result' => $detection['result_image'],
                'result' => $detection['result'],
                'gmt_create' => date('Y-m-d H:i:s'),
                'gmt_modified' => date('Y-m-d H:i:s'),
            );

            $affect = $this->addDetectionInfo($insert);
            if ($affect) {
                $successCnt++;
            }
        }

        return CommonTool::successResult(array(
            'successCnt' => $successCnt
        ));
    }

    private function addDetectionInfo($insert) {
        return DB::table('detection_log')->insertGetId($insert);
    }

    public function getDetectionLogInfo($serialNo) {
        return DB::table('detection_log')->where('serial_no', '=', $serialNo)->first();
    }

    public function searchHistory($startTime, $endTime, $status, $page = 1, $pageSize = 10) {
        $dbTable = DB::table('detection_log');
        $where = [];
        if ($startTime) {
            $where[] = array('time', '>=', $startTime);
        }

        if ($endTime) {
            $where[] = array('time', '<=', $endTime);
        }

        if ($status) {
            $where[] = array('result', '=', $status);
        }

        $total = $dbTable->where($where)->count();
        $skip = ($page - 1) * $pageSize;
        $historyList = $dbTable->where($where)->orderBy('detection_log_id', 'desc')->skip($skip)->take($pageSize)->get()->toArray();

        return array($historyList, $total);
    }
}

