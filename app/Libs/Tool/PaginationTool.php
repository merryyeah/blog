<?php
namespace App\Libs\Tool;

class PaginationTool {
	private $totalNum;
	private $currPageNo = 1;
	private $originPageNo = 1;
	private $totalPageNum;
	private $pageSize = 20;

	//构造分页的URL
	private $route;
	private $params = '';
	private $defautUseGetParams = true;
	private $scheme = false;
	private $pageParamName = 'page';

	//构造分页的文案
	private $prevATitle = 'Previous Page';
	private $prevText = '&lt;&lt;';

	private $nextATitle = 'Next Page';
	private $nextText = '&gt;&gt;';

	private $pageATitle = 'Page %u';

	//分页样式
	private $themeCssClass = 'zc-pagination-light-theme';

	//sm theme
	private $smTheme = false;
	private $smPrevText = '&lt;&lt; 上一页';
	private $smNextText = '下一页 &gt;&gt;';

	//构造分页的布局
	private $edgeLen = 2;
	private $minSideLen = 9;
	private $maxSideLen = 12;
	private $midLen = 9;
	private $remainLen = 4;

	private $totalInfo = '共 <b>[totalNum]</b> 条记录，共 <b>[totalPageNum]</b> 页';
	private $gotoContent = '转到[input]页';
	private $smGotoContent = '[input]';
	private $pageGo = '确定';

	private $layout = array();

	public function __construct($totalNum, $pageSize, $currPageNo, $otherConfig = array()) {
		if ($totalNum) {
			$otherConfig['totalNum'] = $totalNum;
		}
		if ($pageSize) {
			$otherConfig['pageSize'] = $pageSize;
		}
		if ($currPageNo) {
			$otherConfig['currPageNo'] = $currPageNo;
			$this->originPageNo = $currPageNo;
		}

		$config = $otherConfig;

		$this->setDefaultValue();
		$this->config($config);
	}

	public function getTotalNum() {
		return empty($this->totalNum) ? 0 : $this->totalNum;
	}

	private function setDefaultValue() {
		$this->currPageNo = isset($_GET[$this->pageParamName]) ? (int)$_GET[$this->pageParamName] : 1;
        $this->params = $_GET;
	}

	/**
	 * 覆盖与重新计算分页类的各种参数
	 *
	 * @param array $config
	 */
	public function config($config) {
		if (count($config) == 0) {
			return;
		}
		foreach($config as $key => $value) {
			$this->$key = $value;
		}

		return $this->calcPageLayout();
	}

	/**
	 * 计算分页布局
	 *
	 * @return boolean
	 */
	private function calcPageLayout() {
		if ($this->pageSize <= 0) {
			return false;
		}
		$this->totalPageNum = (int)ceil($this->totalNum / $this->pageSize);

		if ($this->currPageNo > $this->totalPageNum) {
			$this->currPageNo = $this->totalPageNum;
		}

		if ($this->totalPageNum <= $this->maxSideLen) {
			$this->layout = range(1, $this->totalPageNum);
		} else {
			//totalPageNum > maxSideLen的情况，根据currPageNo的位置不同而不同
			if (($this->currPageNo + $this->remainLen) <= $this->minSideLen) {

				$this->layout = $this->calcLeftFirst($this->minSideLen);

			} else if (($this->currPageNo + $this->remainLen) <= $this->maxSideLen) {

				$this->layout = $this->calcLeftFirst(($this->currPageNo + $this->remainLen));

			} else if (($this->currPageNo - $this->remainLen) > ($this->totalPageNum - $this->minSideLen)) {

				$this->layout = $this->calcRightFirst($this->totalPageNum - $this->minSideLen + 1);

			} else if (($this->currPageNo - $this->remainLen) > ($this->totalPageNum - $this->maxSideLen)) {

				$this->layout = $this->calcRightFirst($this->currPageNo - $this->remainLen);

			} else {
				$this->layout = $this->calcMid();
			}
		}
	}

	private function calcLeftFirst($realRightEnd) {
		$startLeft = 1;
		$startRight = $realRightEnd;

		$endLeft = $this->totalPageNum - $this->edgeLen + 1;
		$endRight = $this->totalPageNum;

		if (($startRight + 2) < $endLeft) {
			$mid = array('…');
		} else {
			$mid = array($startRight + 1);
		}

		return array_merge(range($startLeft, $startRight), $mid, range($endLeft, $endRight));
	}

	private function calcRightFirst($realLeftStart) {
		$endLeft = $realLeftStart;
		$endRight = $this->totalPageNum;

		$startLeft = 1;
		$startRight = $this->edgeLen;

		if (($startRight + 2) < $endLeft) {
			$mid = array('…');
		} else {
			$mid = array($startRight + 1);
		}

		return array_merge(range($startLeft, $startRight), $mid, range($endLeft, $endRight));
	}

	private function calcMid() {
		$halfMidlen = intval(($this->midLen - 1) / 2);
		$midStart = (($this->currPageNo - $halfMidlen) >= 1) ? ($this->currPageNo - $halfMidlen) : 1;
		$midEnd =  (($this->currPageNo + $halfMidlen) <= $this->totalPageNum) ? ($this->currPageNo + $halfMidlen) : $this->totalPageNum;

		$startLeft = 1;
		$startRight = $this->edgeLen;

		if (($startRight + 2) < $midStart) {
			$margin1 = array('…');
		} else {
			$margin1 = array($startRight + 1);
		}

		$endLeft = $this->totalPageNum - $this->edgeLen + 1;
		$endRight = $this->totalPageNum;

		if (($midEnd + 2) < $endLeft) {
			$margin2 = array('…');
		} else {
			$margin2 = array($startRight + 1);
		}

		return array_merge(range($startLeft, $startRight), $margin1, range($midStart, $midEnd), $margin2, range($endLeft, $endRight));
	}

	/**
	 * 构造指定页码的URL
	 *
	 * @param int $pageNo
	 */
	private function buildPageUrl($pageNo) {
        $requestUri = $_SERVER["REQUEST_URI"];

        $urlArray = parse_url($requestUri);
        $path = $urlArray['path'];
        $params = [];
        if ($pageNo > 1) {
            $params[$this->pageParamName] = $pageNo;
        }

        if (count($params) > 0) {
            $requestUri = $path . '?' . http_build_query($params);
        } else {
            $requestUri = $path;
        }

        return $requestUri;

	}

	/**
	 * 渲染分页链接
	 *
	 * @return string
	 */
	public function renderLinks($isShowTotal = true, $isShowGoto = true, $simpleRender = false, $simpleRenderIsShowGoto = false) {
		if ($this->totalPageNum == 0) {
			return '';
		}

		if ($simpleRender) {
			return $this->simpleRenderLink(false, false, $simpleRenderIsShowGoto);
		}

		$displayStr = sprintf('<div class="pagination zc-pagination %s %s J_zcPaginationGroup">', $this->themeCssClass, ($this->smTheme ? 'zc-pagination-sm' : ''));
		if ($isShowTotal) {
			$displayStr .= str_ireplace(array('[pageSize]', '[totalNum]', '[totalPageNum]'), array($this->pageSize, $this->totalNum, $this->totalPageNum), sprintf('<div class="zc-inline zc-total">%s</div>', $this->totalInfo));
		}
		$displayStr .= '<ul class="zc-inline">';

		// 渲染“上一页”按钮
		if ($this->currPageNo == 1) {
			$displayStr .= '<li class="zc-prev"><span class="zc-current">' . $this->prevText .'</span></li>';
		} else {
			$pageNo = $this->currPageNo - 1;
			$pageUrl = $this->buildPageUrl($pageNo);
			$displayStr .= sprintf('<li class="zc-prev"><a href="%s" title="%s" data-page-no="%d">%s</a></li>', ($pageUrl), $this->prevATitle, $pageNo, $this->prevText);
		}

		// 渲染中间的分页按钮
		foreach ($this->layout as $page) {
			if (is_int($page)) {
				if ($page == $this->currPageNo) {
					$displayStr .= '<li class="active"><span class="zc-current">' . $page .'</span></li>';
				} else {
					$pageUrl = $this->buildPageUrl($page);
					$displayStr .= sprintf('<li><a href="%s" title="%s" data-page-no="%d">%s</a></li>', ($pageUrl), (sprintf($this->pageATitle, $page)), $page, $page);
				}
			} else {
				$displayStr .= '<li class="disabled"><span class="zc-ellipse">…</span></li>';
			}
		}

		// 渲染“下一页”按钮
		if ($this->currPageNo == $this->totalPageNum) {
			$displayStr .= '<li class="zc-next"><span class="zc-current">' . $this->nextText .'</span></li>';
		} else {
			$pageNo = $this->currPageNo + 1;
			$pageUrl = $this->buildPageUrl($pageNo);
			$displayStr .= sprintf('<li class="zc-next"><a href="%s" title="%s" data-page-no="%d">%s</a></li>', ($pageUrl), $this->nextATitle, $pageNo, $this->nextText);
		}

		if ($isShowGoto && ($this->totalPageNum > $this->maxSideLen)) {
			$displayStr .= sprintf('<li class="hidden"><a data-href="%s" data-page-no="%d" class="J_zcPaginGotoPage">%s</a></li>', $this->buildPageUrl(), $page, $page);
			$displayStr .= "</ul>";

			$input = sprintf('<input type="number" step="1" min="1" max="%s" class="form-control input-sm  zc-inline J_zcGotoPageNo" value="%s">',$this->totalPageNum, $this->currPageNo);
			$inputContent = str_ireplace('[input]', $input, $this->gotoContent);
			$displayStr .= sprintf('<div class="zc-inline form-inline zc-gotopage">%s', $inputContent);
			$displayStr .= sprintf('<button class="btn btn-sm btn-default J_zcPaginGo">%s</button></div>', $this->pageGo);
			$displayStr .= "</div>";
		} else {
			$displayStr .= "</ul></div>";
		}

		return $displayStr;
	}

	public function simpleRenderLink($isShowTotalPage, $isShowCurPage, $isShowGoto = false) {
		$displayStr = sprintf('<div class="pagination zc-pagination %s %s J_zcPaginationGroup">', $this->themeCssClass, ($this->smTheme ? 'zc-pagination-sm' : ''));

		if ($isShowTotalPage) {
			$displayStr .= sprintf('<div class="zc-inline zc-total">共 <b>%s</b> 页 </div>', $this->totalPageNum);
		}

		$displayStr .= '<ul class="zc-inline">';

		// 渲染“上一页”按钮
		if ($this->originPageNo == 1) {
			$displayStr .= '<li class="zc-prev"><span class="zc-current">' . $this->smPrevText .'</span></li>';
		} else {
			$pageNo = ($this->originPageNo - 1);
			$pageUrl = $this->buildPageUrl($pageNo);
			$displayStr .= sprintf('<li class="zc-prev"><a href="%s" title="%s" data-page-no="%d">%s</a></li>', ($pageUrl), $this->prevATitle, $pageNo, $this->smPrevText);
		}

		if ($isShowCurPage) {
			$displayStr .= '<li class="active"><span class="zc-current">' . $this->originPageNo .'</span></li>';
		}

		// 渲染“下一页”按钮
		if ($this->totalNum < $this->pageSize) {
			$displayStr .= '<li class="zc-next"><span class="zc-current">' . $this->smNextText .'</span></li>';
		} else {
			$pageNo = $this->originPageNo + 1;
			$pageUrl = $this->buildPageUrl($pageNo);
			$displayStr .= sprintf('<li class="zc-next"><a href="%s" title="%s" data-page-no="%d">%s</a></li>', ($pageUrl), $this->nextATitle, $pageNo, $this->smNextText);

		}

		if ($isShowGoto) {
			$displayStr .= sprintf('<li class="hidden"><a data-href="%s" data-page-no="%d" class="J_zcPaginGotoPage">%s</a></li>', $this->buildPageUrl(), $this->originPageNo, $this->originPageNo);
			$displayStr .= "</ul>";

			$input = sprintf('<input type="number" step="1" min="1" class="form-control input-sm zc-inline J_zcGotoPageNo %s" style="text-align:left;margin:0;" value="" placeholder="GO">', 'w50');
			$inputContent = str_ireplace('[input]', $input, $this->smGotoContent);
			$inputContent .= sprintf('<button class="btn btn-sm btn-default J_zcPaginGo" style="margin-left:5px;">%s</button></div>', $this->pageGo);
			$displayStr .= sprintf('<div class="zc-inline form-inline zc-gotopage" style="margin-left:5px;">%s</div>', $inputContent);
			$displayStr .= "</div>";
		} else {
			$displayStr .= "</ul></div>";
		}

		return $displayStr;
	}
}
