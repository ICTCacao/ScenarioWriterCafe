<?php
// -----------------------------------------------------------
//
// Copyright (C) 2026 ICTCacao Released under the MIT License (see LICENSE).
// 
//     XML 書き出し
//
//     swFuncXML.php
// -----------------------------------------------------------

// -----------------------------------------------------------
//		ディレクトリ内のパスを返す
// -----------------------------------------------------------
function swFuncGetInnerPathOfDirectory( $dir ){
	$iterator = new RecursiveDirectoryIterator($dir);
	$iterator = new RecursiveIteratorIterator($iterator);

	$list = array();
	foreach ($iterator as $fileinfo) { // $fileinfoはSplFiIeInfoオブジェクト
		if ($fileinfo->isFile()) {
			$list[] = $fileinfo->getPathname();
		}
	}

	return $list;
}

// -----------------------------------------------------------
//		core.xml上書き保存
//		swFuncScenarioFilePutCoreXML($dst,$UserName,$fdtTemplateId)
// -----------------------------------------------------------
function swFuncScenarioFilePutCoreXML($dstPath,$UserName,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:title></dc:title><dc:subject></dc:subject><dc:creator>ScenarioWriterCafe</dc:creator><cp:keywords></cp:keywords><dc:description></dc:description><cp:lastModifiedBy>ScenarioWriterCafe</cp:lastModifiedBy><cp:revision>6</cp:revision><dcterms:created xsi:type="dcterms:W3CDTF">2015-12-15T13:38:00Z</dcterms:created><dcterms:modified xsi:type="dcterms:W3CDTF">2015-12-18T05:02:00Z</dcterms:modified></cp:coreProperties>
END_OF_XML;
}
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:title></dc:title><dc:subject></dc:subject><dc:creator>ScenarioWriterCafe</dc:creator><cp:keywords></cp:keywords><cp:lastModifiedBy>ScenarioWriterCafe</cp:lastModifiedBy><cp:revision>7</cp:revision><dcterms:created xsi:type="dcterms:W3CDTF">2015-12-21T07:01:00Z</dcterms:created><dcterms:modified xsi:type="dcterms:W3CDTF">2015-12-22T11:50:00Z</dcterms:modified></cp:coreProperties>
END_OF_XML;
	}
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?><cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:title></dc:title><dc:subject></dc:subject><dc:creator>ScenarioWriterCafe</dc:creator><cp:keywords></cp:keywords><cp:lastModifiedBy>ScenarioWriterCafe</cp:lastModifiedBy><cp:revision>3</cp:revision><dcterms:created xsi:type="dcterms:W3CDTF">2015-12-21T07:01:00Z</dcterms:created><dcterms:modified xsi:type="dcterms:W3CDTF">2015-12-21T07:17:00Z</dcterms:modified></cp:coreProperties>
END_OF_XML;
	}

	//OS 判定
	if (DIRECTORY_SEPARATOR == '\\') {
		$osInfo = 'Windows';
	} else {
		$osInfo = 'NotWindows';
	}
	if ($osInfo == 'NotWindows'){
		chmod($dstPath, 0777);
	}

	//作成するﾌｧｲﾙ名の指定
	$file_name = $dstPath.'/docProps/core.xml';
	//ﾌｧｲﾙが存在したら
	//ﾌｧｲﾙ作成
	file_put_contents($file_name, $fileXML);
	//Windows以外は属性変更
	if ($osInfo == 'NotWindows'){
		//ﾌｧｲﾙの属性変更
		chmod( $file_name, 0755 );
	}

	return;

}
// -----------------------------------------------------------
//		header1.xml上書き保存
//		swFuncScenarioFilePutHeader1XML($dstPath,$ScenarioTitle,$fdtTemplateId)
// -----------------------------------------------------------
function swFuncScenarioFilePutHeader1XML($dstPath,$ScenarioTitle,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:hdr xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 wp14">
<w:p w:rsidR="002034B8" w:rsidRDefault="002034B8">
<w:pPr>
<w:pStyle w:val="af6"/>
</w:pPr>
<w:r>
<w:rPr>
<w:rFonts w:hint="eastAsia"/>
</w:rPr>
<w:t>$ScenarioTitle</w:t>
</w:r>
</w:p>
</w:hdr>
END_OF_XML;

		//OS 判定
		if (DIRECTORY_SEPARATOR == '\\') {
			$osInfo = 'Windows';
		} else {
			$osInfo = 'NotWindows';
		}
		if ($osInfo == 'NotWindows'){
			chmod($dstPath, 0777);
		}
		//作成するﾌｧｲﾙ名の指定
		$file_name = $dstPath.'/word/header1.xml';
		//ﾌｧｲﾙが存在したら
		//ﾌｧｲﾙ作成
		file_put_contents($file_name, $fileXML);
		//Windows以外は属性変更
		if ($osInfo == 'NotWindows'){
			//ﾌｧｲﾙの属性変更
			chmod( $file_name, 0755 );
		}
	}
	return;
}
// -----------------------------------------------------------
//		footer2.xml上書き保存
//		swFuncScenarioFilePutFooter2XML($dstPath,$ScenatioTitle,$fdtTemplateId)
// -----------------------------------------------------------
function swFuncScenarioFilePutFooter2XML($dstPath,$ScenatioTitle,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:ftr xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 wp14"><w:p w:rsidR="004776DD" w:rsidRDefault="004776DD"><w:pPr><w:pStyle w:val="af8"/><w:jc w:val="center"/></w:pPr><w:sdt><w:sdtPr><w:id w:val="2093896771"/><w:docPartObj><w:docPartGallery w:val="Page Numbers (Bottom of Page)"/><w:docPartUnique/></w:docPartObj></w:sdtPr><w:sdtContent><w:r><w:fldChar w:fldCharType="begin"/></w:r><w:r><w:instrText>PAGE   \* MERGEFORMAT</w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r w:rsidR="00F33DCA" w:rsidRPr="00F33DCA"><w:rPr><w:noProof/><w:lang w:val="ja-JP"/></w:rPr><w:t>3</w:t></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r></w:sdtContent></w:sdt></w:p><w:p w:rsidR="002034B8" w:rsidRDefault="002034B8" w:rsidP="00EE6B81"><w:pPr><w:pStyle w:val="af8"/><w:tabs><w:tab w:val="clear" w:pos="4252"/><w:tab w:val="left" w:pos="8504"/></w:tabs></w:pPr></w:p></w:ftr>
END_OF_XML;
	}
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:ftr xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14"><w:p w:rsidR="004E2EB3" w:rsidRPr="00804D7A" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:framePr w:wrap="around" w:vAnchor="text" w:hAnchor="margin" w:xAlign="center" w:y="1"/><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/></w:rPr></w:pPr><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="begin"/></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:instrText xml:space="preserve">PAGE  </w:instrText></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="separate"/></w:r><w:r w:rsidR="00C45694"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:noProof/></w:rPr><w:t>1</w:t></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="end"/></w:r></w:p><w:p w:rsidR="004E2EB3" w:rsidRPr="002A49CF" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:tabs><w:tab w:val="clear" w:pos="8640"/><w:tab w:val="left" w:pos="7668"/><w:tab w:val="right" w:pos="8669"/></w:tabs><w:ind w:right="360"/><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝" w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$ScenatioTitle</w:t></w:r></w:p></w:ftr>
END_OF_XML;
	}
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$fileXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:ftr xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14"><w:p w:rsidR="002423BD" w:rsidRPr="00804D7A" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a6"/><w:framePr w:wrap="around" w:vAnchor="text" w:hAnchor="margin" w:xAlign="center" w:y="1"/><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr></w:pPr><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="begin"/></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:instrText xml:space="preserve">PAGE  </w:instrText></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="separate"/></w:r><w:r w:rsidR="00D642BF"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:noProof/></w:rPr><w:t>2</w:t></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="end"/></w:r></w:p><w:p w:rsidR="002423BD" w:rsidRPr="002A49CF" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a6"/><w:tabs><w:tab w:val="clear" w:pos="8640"/><w:tab w:val="left" w:pos="7668"/><w:tab w:val="right" w:pos="8669"/></w:tabs><w:ind w:right="360"/><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝" w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝" w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$ScenatioTitle</w:t></w:r></w:p></w:ftr>
END_OF_XML;
	}
	
	
	
	//OS 判定
	if (DIRECTORY_SEPARATOR == '\\') {
		$osInfo = 'Windows';
	} else {
		$osInfo = 'NotWindows';
	}
	if ($osInfo == 'NotWindows'){
		chmod($dstPath, 0777);
	}


	//作成するﾌｧｲﾙ名の指定
	$file_name = $dstPath.'/word/footer2.xml';
	//ﾌｧｲﾙが存在したら
	//ﾌｧｲﾙ作成
	file_put_contents($file_name, $fileXML);
	//Windows以外は属性変更
	if ($osInfo == 'NotWindows'){
		//ﾌｧｲﾙの属性変更
		chmod( $file_name, 0755 );
	}

	return;
}
// -----------------------------------------------------------
//		HeaderXML
//		swFuncDocumentXMLHeader()
// -----------------------------------------------------------
function swFuncDocumentXMLHeader($fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 wp14">
<w:body>

END_OF_XML;
	}
	
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14">
<w:body>
END_OF_XML;
	}
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14">
<w:body>

END_OF_XML;
	}



	return	$DocumentXML;
}


// -----------------------------------------------------------
//		表紙
//		swFuncDocumentXMLCover()
// -----------------------------------------------------------
function swFuncDocumentXMLCover($valTitle,$valSubtitle,$valDate,$valVersion,$valWriterName,$valWriterId,$valAddress,$valPhoneNo,$valEmail,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00E74177" w:rsidRPr="00557545" w:rsidRDefault="00E74177" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1200"/></w:pPr></w:p>
<w:p w:rsidR="00557545" w:rsidRPr="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1200"/></w:pPr></w:p>
<w:p w:rsidR="00557545" w:rsidRPr="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1200"/></w:pPr></w:p>
<w:p w:rsidR="00557545" w:rsidRPr="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1200"/></w:pPr></w:p>

<w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1200"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valTitle</w:t>
</w:r></w:p><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a6"/><w:ind w:left="1920"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSubtitle</w:t>
</w:r></w:p><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"/><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"/><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"/><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"/><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="00557545"><w:pPr><w:pStyle w:val="a8"/><w:ind w:left="6000"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>作者名：{$valWriterName}</w:t>
</w:r></w:p><w:p w:rsidR="00557545" w:rsidRDefault="00557545" w:rsidP="004776DD"><w:pPr><w:pStyle w:val="a8"/><w:ind w:left="6000"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valWriterId</w:t>
</w:r>
</w:p>

<w:p w:rsidR="00EE6B81" w:rsidRDefault="00557545"><w:pPr><w:widowControl/><w:sectPr w:rsidR="00EE6B81" w:rsidSect="004776DD"><w:footerReference w:type="default" r:id="rId9"/><w:pgSz w:w="11906" w:h="16838" w:code="9"/><w:pgMar w:top="1440" w:right="1080" w:bottom="1440" w:left="1080" w:header="851" w:footer="992" w:gutter="0"/><w:cols w:space="425"/><w:textDirection w:val="tbRl"/><w:docGrid w:type="lines" w:linePitch="360"/></w:sectPr></w:pPr><w:r><w:br w:type="page"/></w:r></w:p>
END_OF_XML;
	}

	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML

<w:p w:rsidR="005A7C98" w:rsidRDefault="006029D1" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="af1"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="00A31CE1" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$valTitle</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="005A7C98" w:rsidRDefault="00A31CE1" w:rsidP="00A31CE1"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$valSubtitle</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00A31CE1" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ad"/></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valDate</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ad"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valVersion</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ab"/></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>作者名：{$valWriterName}</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ab"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valWriterId</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ab"/><w:jc w:val="left"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ab"/><w:jc w:val="left"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ab"/><w:jc w:val="left"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ac"/></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valAddress</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ac"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valPhoneNo</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ac"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valEmail</w:t></w:r></w:p>
END_OF_XML;
	}


	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="005A7C98" w:rsidRDefault="000968ED" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="af2"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a9"/><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$valTitle</w:t>
</w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="005A7C98" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a9"/><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
<w:t>$valSubtitle</w:t>
</w:r>
</w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="00E820B7" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="00E820B7" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ae"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valDate</w:t></w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="00E820B7" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ae"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valVersion</w:t></w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="a8"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ac"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>作者名：{$valWriterName}</w:t>
</w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ac"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valWriterId</w:t>
</w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ac"/><w:jc w:val="left"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ac"/><w:jc w:val="left"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="00E820B7" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ac"/><w:jc w:val="left"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ad"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valAddress</w:t></w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ad"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valPhoneNo</w:t></w:r></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="ad"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valEmail</w:t></w:r></w:p>
END_OF_XML;
	}


	return	$DocumentXML;
}

// -----------------------------------------------------------
//		登場人物表のタイトル
//		swFuncDocumentXMLCharacterListTitle($valTitle)
// -----------------------------------------------------------
function swFuncDocumentXMLCharacterListTitle($valTitle,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00557545" w:rsidRPr="004776DD" w:rsidRDefault="00FF499A" w:rsidP="004776DD">
<w:pPr><w:pStyle w:val="aa"/></w:pPr><w:r w:rsidRPr="004776DD"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・登場人物</w:t>
</w:r>
</w:p>
<w:p w:rsidR="00BD3A75" w:rsidRDefault="00BD3A75" w:rsidP="00BD3A75"/>

END_OF_XML;
	}
	
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="ae"/></w:pPr><w:r><w:br w:type="page"/></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・登場人物表</w:t></w:r></w:p>
END_OF_XML;
	}

	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="af"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:br w:type="page"/></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・登場人物表</w:t>
</w:r>
</w:p>
END_OF_XML;
	}
	
	return	$DocumentXML;
}


// -----------------------------------------------------------
//		登場人物表
//		swFuncDocumentXMLCharacterList($valCharacterName,$valCharacterChara)
// -----------------------------------------------------------
function swFuncDocumentXMLCharacterList($valCharacterName,$valCharacterChara,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00BD3A75" w:rsidRPr="00BD3A75" w:rsidRDefault="00BD3A75" w:rsidP="00752191">
<w:pPr><w:pStyle w:val="af"/><w:spacing w:after="360"/><w:ind w:left="5680" w:right="120" w:hanging="2800"/></w:pPr><w:r w:rsidRPr="00BD3A75"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterName</w:t></w:r><w:r w:rsidRPr="00BD3A75"><w:tab/></w:r><w:r w:rsidR="00F33DCA"><w:rPr><w:rStyle w:val="af3"/><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterChara</w:t>
</w:r>
</w:p>
END_OF_XML;
	}

	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00A31CE1" w:rsidRPr="009E2619" w:rsidRDefault="004E2EB3" w:rsidP="009E2619"><w:pPr><w:pStyle w:val="af"/></w:pPr><w:r w:rsidRPr="009E2619"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterName</w:t></w:r><w:r w:rsidRPr="009E2619"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/>
<w:t>$valCharacterChara</w:t></w:r></w:p>
END_OF_XML;
	}

	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00D642BF" w:rsidRDefault="002423BD" w:rsidP="00D642BF"><w:pPr><w:pStyle w:val="af0"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterName</w:t>
</w:r><w:r w:rsidRPr="00D0775A"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/>
<w:t>$valCharacterChara</w:t>
</w:r>
</w:p>

END_OF_XML;
	}
	
	return	$DocumentXML;
}
// -----------------------------------------------------------
//		シノプシス
//		swFuncDocumentXMLSynopsis($valTitle,$valSynopsis)
// -----------------------------------------------------------
function swFuncDocumentXMLSynopsis($valTitle,$valSynopsis,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="0032706E" w:rsidRPr="00D170D4" w:rsidRDefault="0032706E" w:rsidP="004776DD">
<w:pPr><w:pStyle w:val="ad"/></w:pPr><w:r w:rsidRPr="00D170D4"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・シノプシス</w:t>
</w:r>
</w:p>
<w:p w:rsidR="00FF499A" w:rsidRDefault="0032706E" w:rsidP="00F33DCA">
<w:pPr><w:pStyle w:val="ac"/><w:ind w:left="2880" w:right="360" w:firstLineChars="100" w:firstLine="280"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSynopsis</w:t>
</w:r>
</w:p>

<w:p w:rsidR="00DF4938" w:rsidRDefault="00DF4938" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="ac"/><w:ind w:left="2880" w:right="360"/></w:pPr></w:p>
<w:p w:rsidR="00150A82" w:rsidRDefault="00150A82" w:rsidP="00D170D4"><w:pPr><w:pStyle w:val="a"/><w:spacing w:before="360" w:after="360"/><w:ind w:left="1200" w:firstLine="1080"/><w:sectPr w:rsidR="00150A82" w:rsidSect="004776DD"><w:type w:val="continuous"/><w:pgSz w:w="11906" w:h="16838" w:code="9"/><w:pgMar w:top="1440" w:right="1080" w:bottom="1440" w:left="1080" w:header="851" w:footer="992" w:gutter="0"/><w:cols w:space="425"/><w:textDirection w:val="tbRl"/><w:docGrid w:type="lines" w:linePitch="360"/></w:sectPr></w:pPr></w:p>

END_OF_XML;
	}

	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00A31CE1" w:rsidRDefault="00A31CE1" w:rsidP="00A31CE1"><w:pPr><w:pStyle w:val="af"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="00A31CE1" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="af0"/></w:pPr><w:r><w:br w:type="page"/></w:r><w:r w:rsidR="004E2EB3"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・慷概・あらすじ</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="001E3C9E"><w:pPr><w:pStyle w:val="af1"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/><w:ind w:left="0" w:firstLine="0"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSynopsis</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="af1"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/><w:ind w:left="0" w:firstLine="0"/></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr><w:sectPr w:rsidR="004E2EB3"><w:footerReference w:type="even" r:id="rId7"/><w:footerReference w:type="default" r:id="rId7"/><w:pgSz w:w="11909" w:h="16834"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440" w:header="720" w:footer="720" w:gutter="0"/><w:pgNumType w:start="0"/><w:cols w:space="720"/><w:titlePg/></w:sectPr></w:pPr></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="005A7C98" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr></w:p>
END_OF_XML;
	}

	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="002423BD" w:rsidRDefault="00D642BF" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="af1"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:br w:type="page"/></w:r><w:r w:rsidR="002423BD"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>「{$valTitle}」・慷概・あらすじ</w:t>
</w:r>
</w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="00D642BF"><w:pPr><w:pStyle w:val="af2"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSynopsis</w:t>
</w:r>
</w:p>

<w:p w:rsidR="002423BD" w:rsidRPr="00E820B7" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:pStyle w:val="af2"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/><w:ind w:left="0" w:firstLine="0"/></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr><w:sectPr w:rsidR="002423BD" w:rsidSect="002423BD"><w:footerReference w:type="even" r:id="rId7"/><w:footerReference w:type="default" r:id="rId7"/><w:pgSz w:w="16834" w:h="11907" w:orient="landscape"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440" w:header="720" w:footer="720" w:gutter="0"/><w:pgNumType w:start="0"/><w:cols w:space="720"/><w:titlePg/><w:textDirection w:val="tbRl"/></w:sectPr></w:pPr></w:p>
<w:p w:rsidR="002423BD" w:rsidRPr="005A7C98" w:rsidRDefault="002423BD" w:rsidP="002423BD"><w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝" w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr></w:p>

END_OF_XML;
	}
	
	return	$DocumentXML;
}
// -----------------------------------------------------------
//		場面
//		swFuncDocumentXMLScene($valSceneName,$valSceneDescription)
// -----------------------------------------------------------
function swFuncDocumentXMLScene($valSceneName,$valSceneDescription,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00FE5970" w:rsidRPr="00010D08" w:rsidRDefault="00010D08" w:rsidP="00D170D4"><w:pPr><w:pStyle w:val="a"/><w:spacing w:before="360" w:after="360"/><w:ind w:left="1200" w:firstLine="1080"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t xml:space="preserve">$valSceneName</w:t>
</w:r><w:r w:rsidR="00FE5970"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:t></w:t></w:r></w:p>
<w:p w:rsidR="004E2778" w:rsidRDefault="00FE5970" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="af4"/><w:spacing w:after="540"/><w:ind w:left="2880" w:right="360" w:firstLine="280"/></w:pPr><w:r w:rsidRPr="004E2778"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSceneDescription</w:t></w:r></w:p>

<w:p w:rsidR="004E2778" w:rsidRDefault="004E2778" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="af0"/><w:spacing w:after="360"/><w:ind w:left="5680" w:right="360" w:hanging="2800"/></w:pPr></w:p>

END_OF_XML;
	}
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a"/><w:ind w:left="602" w:hanging="602"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valSceneName</w:t></w:r></w:p>
<w:p w:rsidR="004E2EB3" w:rsidRPr="00A15DA5" w:rsidRDefault="004E2EB3" w:rsidP="00A31CE1"><w:pPr><w:pStyle w:val="a4"/><w:pBdr><w:left w:val="single" w:sz="8" w:space="6" w:color="auto"/></w:pBdr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:t xml:space="preserve">　</w:t></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/>
<w:t>$valSceneDescription</w:t></w:r></w:p>

END_OF_XML;
	}
	
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a"/><w:ind w:left="602" w:hanging="602"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:lastRenderedPageBreak/>
<w:t>$valSceneName</w:t>
</w:r>
</w:p>

<w:p w:rsidR="004E2EB3" w:rsidRPr="00BE2EAB" w:rsidRDefault="004E2EB3" w:rsidP="00BE2EAB"><w:pPr><w:pStyle w:val="a4"/></w:pPr><w:r w:rsidRPr="00BE2EAB"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:t xml:space="preserve">　</w:t></w:r><w:r w:rsidRPr="00BE2EAB"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/>
<w:t>$valSceneDescription</w:t>
</w:r>
</w:p>
END_OF_XML;
	}
	
	return	$DocumentXML;
}


// -----------------------------------------------------------
//		シナリオ
//		swFuncDocumentXMLScenarioLine($valCharacterDiv,$valScenarioLine)
// -----------------------------------------------------------
function swFuncDocumentXMLScenarioLine($valCharacterDiv,$valScenarioLine,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00752191" w:rsidRPr="00752191" w:rsidRDefault="00752191" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="af0"/><w:spacing w:after="360"/><w:ind w:left="5681" w:right="360"/></w:pPr><w:r w:rsidRPr="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterDiv</w:t></w:r><w:r w:rsidRPr="00752191"><w:tab/></w:r><w:r w:rsidRPr="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valScenarioLine</w:t></w:r></w:p>
END_OF_XML;
	}
	
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="003746CC" w:rsidRDefault="003746CC" w:rsidP="003746CC"><w:pPr><w:pStyle w:val="a5"/></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterDiv</w:t></w:r><w:r><w:tab/></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valScenarioLine</w:t></w:r></w:p>
END_OF_XML;
	}


	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="002423BD" w:rsidRPr="009D7019" w:rsidRDefault="002423BD" w:rsidP="00D642BF"><w:pPr><w:pStyle w:val="a5"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r w:rsidRPr="005A7C98"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterDiv</w:t></w:r><w:r w:rsidRPr="00A15DA5"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/>
<w:t>$valScenarioLine</w:t></w:r></w:p>
END_OF_XML;
	}
	
	
	return	$DocumentXML;
}

// -----------------------------------------------------------
//		ト書
//		swFuncDocumentXMLTogaki($valCharacterDiv,$valScenarioLine)
// -----------------------------------------------------------
function swFuncDocumentXMLTogaki($valCharacterDiv,$valScenarioLine,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="004E2778" w:rsidRPr="00752191" w:rsidRDefault="004E2778" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="afa"/><w:spacing w:after="360"/><w:ind w:left="6660" w:right="360" w:hanging="3780"/></w:pPr><w:r w:rsidRPr="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterDiv</w:t></w:r><w:r w:rsidR="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:tab/></w:r><w:r w:rsidRPr="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valScenarioLine</w:t></w:r></w:p>
END_OF_XML;
	}
	
	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="0009785E" w:rsidRPr="0009785E" w:rsidRDefault="0009785E" w:rsidP="0009785E"><w:pPr><w:pStyle w:val="a4"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t xml:space="preserve">$valCharacterDiv</w:t></w:r><w:bookmarkStart w:id="0" w:name="_GoBack"/><w:bookmarkEnd w:id="0"/><w:r><w:tab/></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valScenarioLine</w:t></w:r></w:p>
END_OF_XML;
	}
	
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="00AF5ABA" w:rsidRPr="009D7019" w:rsidRDefault="00AF5ABA" w:rsidP="00AF5ABA"><w:pPr><w:pStyle w:val="a4"/><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valCharacterDiv</w:t></w:r><w:r><w:tab/></w:r><w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valScenarioLine</w:t></w:r><w:bookmarkStart w:id="0" w:name="_GoBack"/><w:bookmarkEnd w:id="0"/></w:p>
END_OF_XML;
	}	
	return	$DocumentXML;
}
// -----------------------------------------------------------
//		特殊記号
//		swFuncXMLScenarioMark($valMark)
// -----------------------------------------------------------
function swFuncDocumentXMLScenarioMark($valMark,$fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="006A4DFA" w:rsidRDefault="006A4DFA" w:rsidP="00F33DCA">
<w:pPr><w:pStyle w:val="afa"/><w:spacing w:after="360"/><w:ind w:left="6660" w:right="360" w:hanging="3780"/></w:pPr><w:r w:rsidRPr="00752191"><w:tab/></w:r><w:r w:rsidRPr="00752191"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
<w:t>$valMark</w:t>
</w:r>
</w:p>
END_OF_XML;
	}
	
	
	return	$DocumentXML;
}
// -----------------------------------------------------------
//		body end
//		swFuncScenarioXMLBodyEnd()
// -----------------------------------------------------------
function swFuncDocumentXMLBodyEnd($fdtTemplateId){
	//A4縦　縦書き
	if($fdtTemplateId == 'A4TP'){
		$DocumentXML = <<<END_OF_XML
<w:p w:rsidR="002034B8" w:rsidRPr="002034B8" w:rsidRDefault="002034B8" w:rsidP="00F33DCA"><w:pPr><w:pStyle w:val="af0"/><w:spacing w:after="360"/><w:ind w:left="5680" w:right="360" w:hanging="2800"/></w:pPr></w:p>

<w:sectPr w:rsidR="002034B8" w:rsidRPr="002034B8" w:rsidSect="00F33DCA">
<w:footerReference w:type="default" r:id="rId11"/>
<w:type w:val="nextPage"/>
<w:pgSz w:w="11906" w:h="16838" w:code="9"/>
<w:pgMar w:top="1440" w:right="1080" w:bottom="1440" w:left="1080" w:header="851" w:footer="992" w:gutter="0"/>
<w:pgBorders>
<w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
</w:pgBorders>
<w:pgNumType w:start="1"/>
<w:cols w:space="425"/>
<w:textDirection w:val="tbRl"/>
<w:docGrid w:type="lines" w:linePitch="360"/>
</w:sectPr>
</w:body>
</w:document>

END_OF_XML;
	}

	//A4縦　横書き
	if($fdtTemplateId == 'A4YP'){
		$DocumentXML = <<<END_OF_XML
<w:sectPr w:rsidR="003746CC" w:rsidRPr="003746CC" w:rsidSect="004E2EB3">
<w:footerReference w:type="default" r:id="rId8"/>
<w:type w:val="nextPage"/>
<w:pgSz w:w="11909" w:h="16834"/>
<w:pgMar w:top="1701" w:right="1134" w:bottom="2268" w:left="2268" w:header="720" w:footer="1701" w:gutter="0"/>
<w:pgNumType w:start="1"/>
<w:cols w:space="720"/>
</w:sectPr>
</w:body>
</w:document>
END_OF_XML;
	}
	
	//A4横　縦書き
	if($fdtTemplateId == 'A4TL'){
		$DocumentXML = <<<END_OF_XML
<w:sectPr w:rsidR="002423BD" w:rsidRPr="009D7019" w:rsidSect="002423BD">
<w:footerReference w:type="default" r:id="rId8"/>
<w:type w:val="nextPage"/>
<w:pgSz w:w="16834" w:h="11907" w:orient="landscape"/>
<w:pgMar w:top="2268" w:right="1701" w:bottom="1701" w:left="1701" w:header="720" w:footer="851" w:gutter="0"/>
<w:pgNumType w:start="1"/>
<w:cols w:space="720"/>
<w:textDirection w:val="tbRl"/>
</w:sectPr>
</w:body>
</w:document>

END_OF_XML;
	}

	return	$DocumentXML;
}

// --------------------------------------------------------------------------------------------------------




// -----------------------------------------------------------
//
//			XMLファイル出力
//
// -----------------------------------------------------------
//		ヘッダー部
//		swFuncXMLHeader()
// -----------------------------------------------------------
function swFuncXMLHeader(){
	$ReturnXML = <<<END_OF_XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<?mso-application progid="Word.Document"?>
<pkg:package xmlns:pkg="http://schemas.microsoft.com/office/2006/xmlPackage">
	<pkg:part pkg:name="/_rels/.rels" pkg:contentType="application/vnd.openxmlformats-package.relationships+xml" pkg:padding="512"><pkg:xmlData><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/></Relationships></pkg:xmlData></pkg:part><pkg:part pkg:name="/word/_rels/document.xml.rels" pkg:contentType="application/vnd.openxmlformats-package.relationships+xml" pkg:padding="256"><pkg:xmlData><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId8" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer" Target="footer1.xml"/><Relationship Id="rId3" Type="http://schemas.microsoft.com/office/2007/relationships/stylesWithEffects" Target="stylesWithEffects.xml"/><Relationship Id="rId7" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/endnotes" Target="endnotes.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/numbering" Target="numbering.xml"/><Relationship Id="rId6" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footnotes" Target="footnotes.xml"/><Relationship Id="rId11" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/><Relationship Id="rId5" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/webSettings" Target="webSettings.xml"/><Relationship Id="rId10" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/fontTable" Target="fontTable.xml"/><Relationship Id="rId4" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/settings" Target="settings.xml"/><Relationship Id="rId9" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer" Target="footer2.xml"/></Relationships></pkg:xmlData></pkg:part><pkg:part pkg:name="/word/document.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml">
		<pkg:xmlData>
			<w:document mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape">
				<w:body>
					<w:p w:rsidR="005A7C98" w:rsidRDefault="00791E97" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="af1"/></w:pPr><w:bookmarkStart w:id="0" w:name="_GoBack"/><w:bookmarkEnd w:id="0"/></w:p>
					
					
					<!-- シナリオ表紙ページ -->
					
					<!-- 改行 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
END_OF_XML;
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		表紙
//		swFuncXMLCover($valTitle,$valSubtitle,$valDate,$valVersion,$valWriterName,$valWriterId,$valAddress,$valPhoneNo,$valEmail)
// -----------------------------------------------------------
function swFuncXMLCover($valTitle,$valSubtitle,$valDate,$valVersion,$valWriterName,$valWriterId,$valAddress,$valPhoneNo,$valEmail){
	$ReturnXML = <<<END_OF_XML

					<!-- タイトル -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="a8"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:t>$valTitle</w:t></w:r>
					</w:p>
					
					<!-- サブタイトル -->
					<w:p w:rsidR="004E2EB3" w:rsidRPr="005A7C98" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="a8"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr><w:t>$valSubtitle</w:t></w:r>
					</w:p>
					
					<!-- 改行 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					
					
					<!-- date -->
					<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ad"/></w:pPr>
						<w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valDate</w:t>
						</w:r>
					</w:p>
					
					<!-- バージョン -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ad"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valVersion</w:t>
						</w:r>
					</w:p>
					
					<!-- 改行 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					
					<!-- ライター名 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ab"/></w:pPr>
						<w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valWriterName</w:t>
						</w:r>
					</w:p>
					
					<!-- ライターの所属・ID -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ab"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valWriterId</w:t>
						</w:r>
					</w:p>
					
					<!-- 改行 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="11"/></w:pPr></w:p>
					
					
					<!-- 住所 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ac"/></w:pPr>
						<w:r w:rsidRPr="00E820B7"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valAddress</w:t>
						</w:r>
					</w:p>
					
					<!-- 電話番号 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ac"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valPhoneNo</w:t>
						</w:r>
					</w:p>
					
					<!-- メールアドレス -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ac"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valEmail</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		登場人物表
//		swFuncXMLCharacterList($valTitle)
// -----------------------------------------------------------
function swFuncXMLCharacterList($valTitle){
	$ReturnXML = <<<END_OF_XML
					
					<!-- 改ページして登場人物表 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="ae"/></w:pPr>
						<w:r><w:br w:type="page"/></w:r>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 改ページ -->
							<w:lastRenderedPageBreak/>
							<w:t>「{$valTitle}」・登場人物表</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		登場人物表の中身
//		swFuncXMLCharacter($valCharacterName,$valCharacterChara)
// -----------------------------------------------------------
function swFuncXMLCharacter($valCharacterName,$valCharacterChara){
	$ReturnXML = <<<END_OF_XML
					
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="af"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 登場人物名 -->
							<w:t>$valCharacterName</w:t>
						</w:r>
						<w:r w:rsidRPr="00D0775A"><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- tab -->
							<w:tab/>
							<!-- 登場人物説明 -->
							<w:t>$valCharacterChara</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		シノプシス
//		swFuncXMLSynopsis($valTitle,$valSynopsis)
// -----------------------------------------------------------
function swFuncXMLSynopsis($valTitle,$valSynopsis){
	$ReturnXML = <<<END_OF_XML
					
					<!-- シノプシス -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="af0"/></w:pPr><w:r><w:br w:type="page"/></w:r>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 改ページ -->
							<w:lastRenderedPageBreak/>
							<!-- シノプシスタイトル -->
							<w:t>「{$valTitle}」・シノプシス</w:t>
						</w:r>
					</w:p>
					
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="af1"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/><w:ind w:left="0" w:firstLine="568"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- シノプシス -->
							<w:t>$valSynopsis</w:t>
						</w:r>
					</w:p>

					<!-- シナリオスタイル -->
					<w:p w:rsidR="004E2EB3" w:rsidRPr="00E820B7" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="af1"/><w:tabs><w:tab w:val="clear" w:pos="3408"/></w:tabs><w:spacing w:line="360" w:lineRule="auto"/><w:ind w:left="0" w:firstLine="0"/></w:pPr>
					</w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr><w:sectPr w:rsidR="004E2EB3"><w:footerReference w:type="even" r:id="rId8"/><w:footerReference w:type="default" r:id="rId9"/><w:pgSz w:w="11909" w:h="16834"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440" w:header="720" w:footer="720" w:gutter="0"/><w:pgNumType w:start="0"/><w:cols w:space="720"/><w:titlePg/></w:sectPr></w:pPr>
					</w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRPr="005A7C98" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr>
					</w:p>

END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		場　　面
//		swFuncXMLScene($valSceneName,$valSceneDescription)
// -----------------------------------------------------------
function swFuncXMLScene($valSceneName,$valSceneDescription){
	$ReturnXML = <<<END_OF_XML
					
					<!-- 場面 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="a"/><w:ind w:left="1136" w:hanging="1136"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 場面柱 -->
							<w:t>$valSceneName</w:t>
						</w:r>
					</w:p>
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="003C6414">
						<w:pPr><w:pStyle w:val="a4"/><w:ind w:left="1138" w:firstLineChars="100" w:firstLine="200"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 場面説明 -->
							<w:t>$valSceneDescription</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		シナリオ
//		swFuncXMLScenarioLine($valCharacterDiv,$valScenarioLine)
// -----------------------------------------------------------
function swFuncXMLScenarioLine($valCharacterDiv,$valScenarioLine){
	$ReturnXML = <<<END_OF_XML
					
					<!-- 本体 台詞等 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="a5"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- 登場人物名 -->
							<w:t>$valCharacterDiv</w:t>
						</w:r>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<!-- tab -->
							<w:tab/>
							<!-- 台詞等 -->
							<w:t>$valScenarioLine</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		特殊記号
//		swFuncXMLScenarioMark($valMark)
// -----------------------------------------------------------
function swFuncXMLScenarioMark($valMark){
	$ReturnXML = <<<END_OF_XML
					
					<!-- 本体 特殊記号 -->
					<w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3">
						<w:pPr><w:pStyle w:val="a4"/></w:pPr>
						<w:r><w:rPr><w:rFonts w:hint="eastAsia"/></w:rPr>
							<w:t>$valMark</w:t>
						</w:r>
					</w:p>
END_OF_XML;
					
	return	$ReturnXML;
}
// -----------------------------------------------------------
//		body end
//		swFuncXMLBodyEnd($valTitle)
// -----------------------------------------------------------
function swFuncXMLBodyEnd($valTitle){
	$ReturnXML = <<<END_OF_XML
					
					<!-- body end -->
					<w:sectPr w:rsidR="004E2EB3" w:rsidRPr="009D7019" w:rsidSect="004E2EB3"><w:pgSz w:w="11909" w:h="16834"/><w:pgMar w:top="1701" w:right="1134" w:bottom="2268" w:left="2268" w:header="720" w:footer="1701" w:gutter="0"/><w:pgNumType w:start="1"/><w:cols w:space="720"/></w:sectPr>
				</w:body>
			</w:document>
		</pkg:xmlData>
	</pkg:part>

<pkg:part pkg:name="/word/footer2.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml">
	<pkg:xmlData>
		<w:ftr mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:p w:rsidR="004E2EB3" w:rsidRPr="00804D7A" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:framePr w:wrap="around" w:vAnchor="text" w:hAnchor="margin" w:xAlign="right" w:y="1"/><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/></w:rPr></w:pPr><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="begin"/></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:instrText xml:space="preserve">PAGE  </w:instrText></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="separate"/></w:r><w:r w:rsidR="00401F87"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:noProof/></w:rPr><w:t>7</w:t></w:r><w:r w:rsidRPr="00804D7A"><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr><w:fldChar w:fldCharType="end"/></w:r></w:p><w:p w:rsidR="004E2EB3" w:rsidRPr="002A49CF" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:tabs><w:tab w:val="clear" w:pos="8640"/><w:tab w:val="left" w:pos="7668"/><w:tab w:val="right" w:pos="8669"/></w:tabs><w:ind w:right="360"/><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="ＭＳ Ｐ明朝" w:eastAsia="ＭＳ Ｐ明朝" w:hAnsi="ＭＳ Ｐ明朝" w:cs="ＭＳ Ｐ明朝" w:hint="eastAsia"/><w:lang w:eastAsia="ja-JP"/></w:rPr>
			<w:t>$valTitle</w:t></w:r></w:p>
		</w:ftr>
	</pkg:xmlData>
</pkg:part>
	
	
	
	<pkg:part pkg:name="/word/footnotes.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footnotes+xml"><pkg:xmlData><w:footnotes mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:footnote w:type="separator" w:id="-1"><w:p w:rsidR="00791E97" w:rsidRDefault="00791E97"><w:r><w:separator/></w:r></w:p></w:footnote><w:footnote w:type="continuationSeparator" w:id="0"><w:p w:rsidR="00791E97" w:rsidRDefault="00791E97"><w:r><w:continuationSeparator/></w:r></w:p></w:footnote></w:footnotes></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/endnotes.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.endnotes+xml"><pkg:xmlData><w:endnotes mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:endnote w:type="separator" w:id="-1"><w:p w:rsidR="00791E97" w:rsidRDefault="00791E97"><w:r><w:separator/></w:r></w:p></w:endnote><w:endnote w:type="continuationSeparator" w:id="0"><w:p w:rsidR="00791E97" w:rsidRDefault="00791E97"><w:r><w:continuationSeparator/></w:r></w:p></w:endnote></w:endnotes></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/footer1.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.footer+xml"><pkg:xmlData><w:ftr mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:framePr w:wrap="around" w:vAnchor="text" w:hAnchor="margin" w:xAlign="right" w:y="1"/></w:pPr><w:r><w:fldChar w:fldCharType="begin"/></w:r><w:r><w:instrText xml:space="preserve">PAGE  </w:instrText></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r></w:p><w:p w:rsidR="004E2EB3" w:rsidRDefault="004E2EB3" w:rsidP="004E2EB3"><w:pPr><w:pStyle w:val="a6"/><w:ind w:right="360"/></w:pPr></w:p></w:ftr></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/theme/theme1.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.theme+xml"><pkg:xmlData><a:theme name="Office ​​テーマ" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"><a:themeElements><a:clrScheme name="Office"><a:dk1><a:sysClr val="windowText" lastClr="000000"/></a:dk1><a:lt1><a:sysClr val="window" lastClr="FFFFFF"/></a:lt1><a:dk2><a:srgbClr val="1F497D"/></a:dk2><a:lt2><a:srgbClr val="EEECE1"/></a:lt2><a:accent1><a:srgbClr val="4F81BD"/></a:accent1><a:accent2><a:srgbClr val="C0504D"/></a:accent2><a:accent3><a:srgbClr val="9BBB59"/></a:accent3><a:accent4><a:srgbClr val="8064A2"/></a:accent4><a:accent5><a:srgbClr val="4BACC6"/></a:accent5><a:accent6><a:srgbClr val="F79646"/></a:accent6><a:hlink><a:srgbClr val="0000FF"/></a:hlink><a:folHlink><a:srgbClr val="800080"/></a:folHlink></a:clrScheme><a:fontScheme name="Office"><a:majorFont><a:latin typeface="Arial"/><a:ea typeface=""/><a:cs typeface=""/><a:font script="Jpan" typeface="ＭＳ ゴシック"/><a:font script="Hang" typeface="맑은 고딕"/><a:font script="Hans" typeface="宋体"/><a:font script="Hant" typeface="新細明體"/><a:font script="Arab" typeface="Times New Roman"/><a:font script="Hebr" typeface="Times New Roman"/><a:font script="Thai" typeface="Angsana New"/><a:font script="Ethi" typeface="Nyala"/><a:font script="Beng" typeface="Vrinda"/><a:font script="Gujr" typeface="Shruti"/><a:font script="Khmr" typeface="MoolBoran"/><a:font script="Knda" typeface="Tunga"/><a:font script="Guru" typeface="Raavi"/><a:font script="Cans" typeface="Euphemia"/><a:font script="Cher" typeface="Plantagenet Cherokee"/><a:font script="Yiii" typeface="Microsoft Yi Baiti"/><a:font script="Tibt" typeface="Microsoft Himalaya"/><a:font script="Thaa" typeface="MV Boli"/><a:font script="Deva" typeface="Mangal"/><a:font script="Telu" typeface="Gautami"/><a:font script="Taml" typeface="Latha"/><a:font script="Syrc" typeface="Estrangelo Edessa"/><a:font script="Orya" typeface="Kalinga"/><a:font script="Mlym" typeface="Kartika"/><a:font script="Laoo" typeface="DokChampa"/><a:font script="Sinh" typeface="Iskoola Pota"/><a:font script="Mong" typeface="Mongolian Baiti"/><a:font script="Viet" typeface="Times New Roman"/><a:font script="Uigh" typeface="Microsoft Uighur"/><a:font script="Geor" typeface="Sylfaen"/></a:majorFont><a:minorFont><a:latin typeface="Century"/><a:ea typeface=""/><a:cs typeface=""/><a:font script="Jpan" typeface="ＭＳ 明朝"/><a:font script="Hang" typeface="맑은 고딕"/><a:font script="Hans" typeface="宋体"/><a:font script="Hant" typeface="新細明體"/><a:font script="Arab" typeface="Arial"/><a:font script="Hebr" typeface="Arial"/><a:font script="Thai" typeface="Cordia New"/><a:font script="Ethi" typeface="Nyala"/><a:font script="Beng" typeface="Vrinda"/><a:font script="Gujr" typeface="Shruti"/><a:font script="Khmr" typeface="DaunPenh"/><a:font script="Knda" typeface="Tunga"/><a:font script="Guru" typeface="Raavi"/><a:font script="Cans" typeface="Euphemia"/><a:font script="Cher" typeface="Plantagenet Cherokee"/><a:font script="Yiii" typeface="Microsoft Yi Baiti"/><a:font script="Tibt" typeface="Microsoft Himalaya"/><a:font script="Thaa" typeface="MV Boli"/><a:font script="Deva" typeface="Mangal"/><a:font script="Telu" typeface="Gautami"/><a:font script="Taml" typeface="Latha"/><a:font script="Syrc" typeface="Estrangelo Edessa"/><a:font script="Orya" typeface="Kalinga"/><a:font script="Mlym" typeface="Kartika"/><a:font script="Laoo" typeface="DokChampa"/><a:font script="Sinh" typeface="Iskoola Pota"/><a:font script="Mong" typeface="Mongolian Baiti"/><a:font script="Viet" typeface="Arial"/><a:font script="Uigh" typeface="Microsoft Uighur"/><a:font script="Geor" typeface="Sylfaen"/></a:minorFont></a:fontScheme><a:fmtScheme name="Office"><a:fillStyleLst><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:gradFill rotWithShape="1"><a:gsLst><a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="50000"/><a:satMod val="300000"/></a:schemeClr></a:gs><a:gs pos="35000"><a:schemeClr val="phClr"><a:tint val="37000"/><a:satMod val="300000"/></a:schemeClr></a:gs><a:gs pos="100000"><a:schemeClr val="phClr"><a:tint val="15000"/><a:satMod val="350000"/></a:schemeClr></a:gs></a:gsLst><a:lin ang="16200000" scaled="1"/></a:gradFill><a:gradFill rotWithShape="1"><a:gsLst><a:gs pos="0"><a:schemeClr val="phClr"><a:shade val="51000"/><a:satMod val="130000"/></a:schemeClr></a:gs><a:gs pos="80000"><a:schemeClr val="phClr"><a:shade val="93000"/><a:satMod val="130000"/></a:schemeClr></a:gs><a:gs pos="100000"><a:schemeClr val="phClr"><a:shade val="94000"/><a:satMod val="135000"/></a:schemeClr></a:gs></a:gsLst><a:lin ang="16200000" scaled="0"/></a:gradFill></a:fillStyleLst><a:lnStyleLst><a:ln w="9525" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"><a:shade val="95000"/><a:satMod val="105000"/></a:schemeClr></a:solidFill><a:prstDash val="solid"/></a:ln><a:ln w="25400" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:prstDash val="solid"/></a:ln><a:ln w="38100" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:prstDash val="solid"/></a:ln></a:lnStyleLst><a:effectStyleLst><a:effectStyle><a:effectLst><a:outerShdw blurRad="40000" dist="20000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="38000"/></a:srgbClr></a:outerShdw></a:effectLst></a:effectStyle><a:effectStyle><a:effectLst><a:outerShdw blurRad="40000" dist="23000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="35000"/></a:srgbClr></a:outerShdw></a:effectLst></a:effectStyle><a:effectStyle><a:effectLst><a:outerShdw blurRad="40000" dist="23000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="35000"/></a:srgbClr></a:outerShdw></a:effectLst><a:scene3d><a:camera prst="orthographicFront"><a:rot lat="0" lon="0" rev="0"/></a:camera><a:lightRig rig="threePt" dir="t"><a:rot lat="0" lon="0" rev="1200000"/></a:lightRig></a:scene3d><a:sp3d><a:bevelT w="63500" h="25400"/></a:sp3d></a:effectStyle></a:effectStyleLst><a:bgFillStyleLst><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:gradFill rotWithShape="1"><a:gsLst><a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="40000"/><a:satMod val="350000"/></a:schemeClr></a:gs><a:gs pos="40000"><a:schemeClr val="phClr"><a:tint val="45000"/><a:shade val="99000"/><a:satMod val="350000"/></a:schemeClr></a:gs><a:gs pos="100000"><a:schemeClr val="phClr"><a:shade val="20000"/><a:satMod val="255000"/></a:schemeClr></a:gs></a:gsLst><a:path path="circle"><a:fillToRect l="50000" t="-80000" r="50000" b="180000"/></a:path></a:gradFill><a:gradFill rotWithShape="1"><a:gsLst><a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="80000"/><a:satMod val="300000"/></a:schemeClr></a:gs><a:gs pos="100000"><a:schemeClr val="phClr"><a:shade val="30000"/><a:satMod val="200000"/></a:schemeClr></a:gs></a:gsLst><a:path path="circle"><a:fillToRect l="50000" t="50000" r="50000" b="50000"/></a:path></a:gradFill></a:bgFillStyleLst></a:fmtScheme></a:themeElements><a:objectDefaults/><a:extraClrSchemeLst/></a:theme></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/settings.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.settings+xml"><pkg:xmlData><w:settings mc:Ignorable="w14" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:sl="http://schemas.openxmlformats.org/schemaLibrary/2006/main"><w:zoom w:val="bestFit" w:percent="142"/><w:embedSystemFonts/><w:bordersDoNotSurroundHeader/><w:bordersDoNotSurroundFooter/><w:attachedTemplate r:id="rId1"/><w:stylePaneFormatFilter w:val="3F01" w:allStyles="1" w:customStyles="0" w:latentStyles="0" w:stylesInUse="0" w:headingStyles="0" w:numberingStyles="0" w:tableStyles="0" w:directFormattingOnRuns="1" w:directFormattingOnParagraphs="1" w:directFormattingOnNumbering="1" w:directFormattingOnTables="1" w:clearFormatting="1" w:top3HeadingStyles="1" w:visibleStyles="0" w:alternateStyleNames="0"/><w:stylePaneSortMethod w:val="0000"/><w:defaultTabStop w:val="720"/><w:displayHorizontalDrawingGridEvery w:val="0"/><w:displayVerticalDrawingGridEvery w:val="0"/><w:doNotUseMarginsForDrawingGridOrigin/><w:noPunctuationKerning/><w:characterSpacingControl w:val="doNotCompress"/><w:doNotValidateAgainstSchema/><w:doNotDemarcateInvalidXml/><w:footnotePr><w:footnote w:id="-1"/><w:footnote w:id="0"/></w:footnotePr><w:endnotePr><w:endnote w:id="-1"/><w:endnote w:id="0"/></w:endnotePr><w:compat><w:useFELayout/><w:compatSetting w:name="compatibilityMode" w:uri="http://schemas.microsoft.com/office/word" w:val="14"/><w:compatSetting w:name="overrideTableStyleFontSizeAndJustification" w:uri="http://schemas.microsoft.com/office/word" w:val="1"/><w:compatSetting w:name="enableOpenTypeFeatures" w:uri="http://schemas.microsoft.com/office/word" w:val="1"/><w:compatSetting w:name="doNotFlipMirrorIndents" w:uri="http://schemas.microsoft.com/office/word" w:val="1"/></w:compat><w:rsids><w:rsidRoot w:val="003237D0"/><w:rsid w:val="003237D0"/><w:rsid w:val="00401F87"/><w:rsid w:val="004E2EB3"/><w:rsid w:val="00791E97"/><w:rsid w:val="00826E54"/></w:rsids><m:mathPr><m:mathFont m:val="Cambria Math"/><m:brkBin m:val="before"/><m:brkBinSub m:val="--"/><m:smallFrac m:val="0"/><m:dispDef m:val="0"/><m:lMargin m:val="0"/><m:rMargin m:val="0"/><m:defJc m:val="centerGroup"/><m:wrapRight/><m:intLim m:val="subSup"/><m:naryLim m:val="subSup"/></m:mathPr><w:themeFontLang w:val="en-US" w:eastAsia="ja-JP"/><w:clrSchemeMapping w:bg1="light1" w:t1="dark1" w:bg2="light2" w:t2="dark2" w:accent1="accent1" w:accent2="accent2" w:accent3="accent3" w:accent4="accent4" w:accent5="accent5" w:accent6="accent6" w:hyperlink="hyperlink" w:followedHyperlink="followedHyperlink"/><w:doNotIncludeSubdocsInStats/><w:doNotAutoCompressPictures/><w:shapeDefaults><o:shapedefaults v:ext="edit" spidmax="1026"><v:textbox inset="5.85pt,.7pt,5.85pt,.7pt"/></o:shapedefaults><o:shapelayout v:ext="edit"><o:idmap v:ext="edit" data="1"/></o:shapelayout></w:shapeDefaults><w:doNotEmbedSmartTags/><w:decimalSymbol w:val="."/><w:listSeparator w:val=","/></w:settings></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/_rels/settings.xml.rels" pkg:contentType="application/vnd.openxmlformats-package.relationships+xml"><pkg:xmlData><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/attachedTemplate" Target="file:///C:\Users\SKANKOU04\Desktop\Script.Template.A4.Yoko.dot" TargetMode="External"/></Relationships></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/styles.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"><pkg:xmlData><w:styles mc:Ignorable="w14" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"><w:docDefaults><w:rPrDefault><w:rPr><w:rFonts w:ascii="Cambria" w:eastAsia="ＭＳ 明朝" w:hAnsi="Cambria" w:cs="Times New Roman"/><w:lang w:val="en-US" w:eastAsia="ja-JP" w:bidi="ar-SA"/></w:rPr></w:rPrDefault><w:pPrDefault/></w:docDefaults><w:latentStyles w:defLockedState="0" w:defUIPriority="0" w:defSemiHidden="0" w:defUnhideWhenUsed="0" w:defQFormat="0" w:count="267"><w:lsdException w:name="Normal" w:qFormat="1"/><w:lsdException w:name="heading 1" w:qFormat="1"/><w:lsdException w:name="heading 2" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 3" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 4" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 5" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 6" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 7" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 8" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 9" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="caption" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="Title" w:qFormat="1"/><w:lsdException w:name="Subtitle" w:qFormat="1"/><w:lsdException w:name="Strong" w:qFormat="1"/><w:lsdException w:name="Emphasis" w:qFormat="1"/><w:lsdException w:name="No Spacing" w:qFormat="1"/><w:lsdException w:name="List Paragraph" w:qFormat="1"/><w:lsdException w:name="Quote" w:qFormat="1"/><w:lsdException w:name="Intense Quote" w:qFormat="1"/><w:lsdException w:name="Subtle Emphasis" w:qFormat="1"/><w:lsdException w:name="Intense Emphasis" w:qFormat="1"/><w:lsdException w:name="Subtle Reference" w:qFormat="1"/><w:lsdException w:name="Intense Reference" w:qFormat="1"/><w:lsdException w:name="Book Title" w:qFormat="1"/><w:lsdException w:name="TOC Heading" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/></w:latentStyles><w:style w:type="paragraph" w:default="1" w:styleId="a0"><w:name w:val="Normal"/><w:qFormat/><w:rsid w:val="00A52FE9"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial"/><w:sz w:val="24"/><w:szCs w:val="24"/><w:lang w:eastAsia="en-US"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="1"><w:name w:val="heading 1"/><w:basedOn w:val="a0"/><w:next w:val="a0"/><w:link w:val="10"/><w:uiPriority w:val="9"/><w:qFormat/><w:rsid w:val="006D64D0"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="480"/><w:outlineLvl w:val="0"/></w:pPr><w:rPr><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:b/><w:bCs/><w:color w:val="345A8A"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style><w:style w:type="character" w:default="1" w:styleId="a1"><w:name w:val="Default Paragraph Font"/><w:uiPriority w:val="1"/><w:semiHidden/><w:unhideWhenUsed/></w:style><w:style w:type="table" w:default="1" w:styleId="a2"><w:name w:val="Normal Table"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:tblPr><w:tblInd w:w="0" w:type="dxa"/><w:tblCellMar><w:top w:w="0" w:type="dxa"/><w:left w:w="108" w:type="dxa"/><w:bottom w:w="0" w:type="dxa"/><w:right w:w="108" w:type="dxa"/></w:tblCellMar></w:tblPr></w:style><w:style w:type="numbering" w:default="1" w:styleId="a3"><w:name w:val="No List"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a4"><w:name w:val="ト書き・アクション"/><w:basedOn w:val="a5"/><w:qFormat/><w:rsid w:val="005A7C98"/><w:pPr><w:ind w:left="3408" w:hanging="2270"/></w:pPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a"><w:name w:val="柱・シーン"/><w:basedOn w:val="1"/><w:next w:val="a4"/><w:qFormat/><w:rsid w:val="00FD0F4B"/><w:pPr><w:numPr><w:numId w:val="1"/></w:numPr><w:pBdr><w:top w:val="single" w:sz="8" w:space="6" w:color="auto"/><w:left w:val="single" w:sz="8" w:space="4" w:color="auto"/><w:bottom w:val="single" w:sz="8" w:space="6" w:color="auto"/></w:pBdr><w:spacing w:before="240" w:after="480"/><w:ind w:left="1846" w:hanging="1846"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:color w:val="auto"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="character" w:customStyle="1" w:styleId="10"><w:name w:val="見出し 1 (文字)"/><w:basedOn w:val="a1"/><w:link w:val="1"/><w:uiPriority w:val="9"/><w:rsid w:val="006D64D0"/><w:rPr><w:rFonts w:ascii="Calibri" w:eastAsia="Times New Roman" w:hAnsi="Calibri" w:cs="Times New Roman"/><w:b/><w:bCs/><w:color w:val="345A8A"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="a6"><w:name w:val="footer"/><w:basedOn w:val="a0"/><w:link w:val="a7"/><w:rsid w:val="002A49CF"/><w:pPr><w:tabs><w:tab w:val="center" w:pos="4320"/><w:tab w:val="right" w:pos="8640"/></w:tabs></w:pPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a5"><w:name w:val="台詞"/><w:basedOn w:val="a0"/><w:qFormat/><w:rsid w:val="005A7C98"/><w:pPr><w:pBdr><w:left w:val="single" w:sz="8" w:space="4" w:color="auto"/></w:pBdr><w:spacing w:after="120" w:line="360" w:lineRule="auto"/><w:ind w:left="2698" w:hanging="1560"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="11"><w:name w:val="標準1"/><w:basedOn w:val="a0"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:cs="ＭＳ Ｐ明朝"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a8"><w:name w:val="表紙・タイトル"/><w:basedOn w:val="a9"/><w:next w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:sz w:val="48"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="a9"><w:name w:val="header"/><w:basedOn w:val="a0"/><w:link w:val="aa"/><w:rsid w:val="00E820B7"/><w:pPr><w:tabs><w:tab w:val="center" w:pos="4320"/><w:tab w:val="right" w:pos="8640"/></w:tabs></w:pPr></w:style><w:style w:type="character" w:customStyle="1" w:styleId="aa"><w:name w:val="ヘッダー (文字)"/><w:basedOn w:val="a1"/><w:link w:val="a9"/><w:rsid w:val="00E820B7"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial" w:cs="Times New Roman"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ab"><w:name w:val="表紙・作者名"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ac"><w:name w:val="表紙・連絡先"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="right"/></w:pPr><w:rPr><w:sz w:val="24"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ad"><w:name w:val="表紙・日付"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ae"><w:name w:val="登場人物・タイトル"/><w:basedOn w:val="11"/><w:next w:val="af"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:spacing w:after="840"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af"><w:name w:val="登場人物・リスト"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:tabs><w:tab w:val="left" w:pos="3408"/></w:tabs><w:ind w:left="3408" w:hanging="3408"/></w:pPr><w:rPr><w:sz w:val="24"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af0"><w:name w:val="慷概・タイトル"/><w:basedOn w:val="ae"/><w:qFormat/><w:rsid w:val="002A49CF"/></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af1"><w:name w:val="慷概・本文"/><w:basedOn w:val="af"/><w:qFormat/><w:rsid w:val="002A49CF"/></w:style><w:style w:type="character" w:customStyle="1" w:styleId="a7"><w:name w:val="フッター (文字)"/><w:basedOn w:val="a1"/><w:link w:val="a6"/><w:rsid w:val="002A49CF"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial" w:cs="Times New Roman"/></w:rPr></w:style></w:styles></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/stylesWithEffects.xml" pkg:contentType="application/vnd.ms-word.stylesWithEffects+xml"><pkg:xmlData><w:styles mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:docDefaults><w:rPrDefault><w:rPr><w:rFonts w:ascii="Cambria" w:eastAsia="ＭＳ 明朝" w:hAnsi="Cambria" w:cs="Times New Roman"/><w:lang w:val="en-US" w:eastAsia="ja-JP" w:bidi="ar-SA"/></w:rPr></w:rPrDefault><w:pPrDefault/></w:docDefaults><w:latentStyles w:defLockedState="0" w:defUIPriority="0" w:defSemiHidden="0" w:defUnhideWhenUsed="0" w:defQFormat="0" w:count="267"><w:lsdException w:name="Normal" w:qFormat="1"/><w:lsdException w:name="heading 1" w:qFormat="1"/><w:lsdException w:name="heading 2" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 3" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 4" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 5" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 6" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 7" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 8" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="heading 9" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="caption" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/><w:lsdException w:name="Title" w:qFormat="1"/><w:lsdException w:name="Subtitle" w:qFormat="1"/><w:lsdException w:name="Strong" w:qFormat="1"/><w:lsdException w:name="Emphasis" w:qFormat="1"/><w:lsdException w:name="No Spacing" w:qFormat="1"/><w:lsdException w:name="List Paragraph" w:qFormat="1"/><w:lsdException w:name="Quote" w:qFormat="1"/><w:lsdException w:name="Intense Quote" w:qFormat="1"/><w:lsdException w:name="Subtle Emphasis" w:qFormat="1"/><w:lsdException w:name="Intense Emphasis" w:qFormat="1"/><w:lsdException w:name="Subtle Reference" w:qFormat="1"/><w:lsdException w:name="Intense Reference" w:qFormat="1"/><w:lsdException w:name="Book Title" w:qFormat="1"/><w:lsdException w:name="TOC Heading" w:semiHidden="1" w:unhideWhenUsed="1" w:qFormat="1"/></w:latentStyles><w:style w:type="paragraph" w:default="1" w:styleId="a0"><w:name w:val="Normal"/><w:qFormat/><w:rsid w:val="00A52FE9"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial"/><w:sz w:val="24"/><w:szCs w:val="24"/><w:lang w:eastAsia="en-US"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="1"><w:name w:val="heading 1"/><w:basedOn w:val="a0"/><w:next w:val="a0"/><w:link w:val="10"/><w:uiPriority w:val="9"/><w:qFormat/><w:rsid w:val="006D64D0"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="480"/><w:outlineLvl w:val="0"/></w:pPr><w:rPr><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:b/><w:bCs/><w:color w:val="345A8A"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style><w:style w:type="character" w:default="1" w:styleId="a1"><w:name w:val="Default Paragraph Font"/><w:uiPriority w:val="1"/><w:semiHidden/><w:unhideWhenUsed/></w:style><w:style w:type="table" w:default="1" w:styleId="a2"><w:name w:val="Normal Table"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:tblPr><w:tblInd w:w="0" w:type="dxa"/><w:tblCellMar><w:top w:w="0" w:type="dxa"/><w:left w:w="108" w:type="dxa"/><w:bottom w:w="0" w:type="dxa"/><w:right w:w="108" w:type="dxa"/></w:tblCellMar></w:tblPr></w:style><w:style w:type="numbering" w:default="1" w:styleId="a3"><w:name w:val="No List"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a4"><w:name w:val="ト書き・アクション"/><w:basedOn w:val="a5"/><w:qFormat/><w:rsid w:val="005A7C98"/><w:pPr><w:ind w:left="3408" w:hanging="2270"/></w:pPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a"><w:name w:val="柱・シーン"/><w:basedOn w:val="1"/><w:next w:val="a4"/><w:qFormat/><w:rsid w:val="00FD0F4B"/><w:pPr><w:numPr><w:numId w:val="1"/></w:numPr><w:pBdr><w:top w:val="single" w:sz="8" w:space="6" w:color="auto"/><w:left w:val="single" w:sz="8" w:space="4" w:color="auto"/><w:bottom w:val="single" w:sz="8" w:space="6" w:color="auto"/></w:pBdr><w:spacing w:before="240" w:after="480"/><w:ind w:left="1846" w:hanging="1846"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:color w:val="auto"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="character" w:customStyle="1" w:styleId="10"><w:name w:val="見出し 1 (文字)"/><w:basedOn w:val="a1"/><w:link w:val="1"/><w:uiPriority w:val="9"/><w:rsid w:val="006D64D0"/><w:rPr><w:rFonts w:ascii="Calibri" w:eastAsia="Times New Roman" w:hAnsi="Calibri" w:cs="Times New Roman"/><w:b/><w:bCs/><w:color w:val="345A8A"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="a6"><w:name w:val="footer"/><w:basedOn w:val="a0"/><w:link w:val="a7"/><w:rsid w:val="002A49CF"/><w:pPr><w:tabs><w:tab w:val="center" w:pos="4320"/><w:tab w:val="right" w:pos="8640"/></w:tabs></w:pPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a5"><w:name w:val="台詞"/><w:basedOn w:val="a0"/><w:qFormat/><w:rsid w:val="005A7C98"/><w:pPr><w:pBdr><w:left w:val="single" w:sz="8" w:space="4" w:color="auto"/></w:pBdr><w:spacing w:after="120" w:line="360" w:lineRule="auto"/><w:ind w:left="2698" w:hanging="1560"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="11"><w:name w:val="標準1"/><w:basedOn w:val="a0"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:cs="ＭＳ Ｐ明朝"/><w:sz w:val="20"/><w:lang w:eastAsia="ja-JP"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="a8"><w:name w:val="表紙・タイトル"/><w:basedOn w:val="a9"/><w:next w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝"/><w:sz w:val="48"/></w:rPr></w:style><w:style w:type="paragraph" w:styleId="a9"><w:name w:val="header"/><w:basedOn w:val="a0"/><w:link w:val="aa"/><w:rsid w:val="00E820B7"/><w:pPr><w:tabs><w:tab w:val="center" w:pos="4320"/><w:tab w:val="right" w:pos="8640"/></w:tabs></w:pPr></w:style><w:style w:type="character" w:customStyle="1" w:styleId="aa"><w:name w:val="ヘッダー (文字)"/><w:basedOn w:val="a1"/><w:link w:val="a9"/><w:rsid w:val="00E820B7"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial" w:cs="Times New Roman"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ab"><w:name w:val="表紙・作者名"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ac"><w:name w:val="表紙・連絡先"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00E820B7"/><w:pPr><w:jc w:val="right"/></w:pPr><w:rPr><w:sz w:val="24"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ad"><w:name w:val="表紙・日付"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:jc w:val="center"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="ae"><w:name w:val="登場人物・タイトル"/><w:basedOn w:val="11"/><w:next w:val="af"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:spacing w:after="840"/></w:pPr><w:rPr><w:sz w:val="28"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af"><w:name w:val="登場人物・リスト"/><w:basedOn w:val="11"/><w:qFormat/><w:rsid w:val="00D0775A"/><w:pPr><w:tabs><w:tab w:val="left" w:pos="3408"/></w:tabs><w:ind w:left="3408" w:hanging="3408"/></w:pPr><w:rPr><w:sz w:val="24"/></w:rPr></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af0"><w:name w:val="慷概・タイトル"/><w:basedOn w:val="ae"/><w:qFormat/><w:rsid w:val="002A49CF"/></w:style><w:style w:type="paragraph" w:customStyle="1" w:styleId="af1"><w:name w:val="慷概・本文"/><w:basedOn w:val="af"/><w:qFormat/><w:rsid w:val="002A49CF"/></w:style><w:style w:type="character" w:customStyle="1" w:styleId="a7"><w:name w:val="フッター (文字)"/><w:basedOn w:val="a1"/><w:link w:val="a6"/><w:rsid w:val="002A49CF"/><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Times New Roman" w:hAnsi="Arial" w:cs="Times New Roman"/></w:rPr></w:style></w:styles></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/fontTable.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.fontTable+xml"><pkg:xmlData><w:fonts mc:Ignorable="w14" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"><w:font w:name="ＭＳ 明朝"><w:altName w:val="MS Mincho"/><w:panose1 w:val="02020609040205080304"/><w:charset w:val="80"/><w:family w:val="roman"/><w:pitch w:val="fixed"/><w:sig w:usb0="E00002FF" w:usb1="6AC7FDFB" w:usb2="00000012" w:usb3="00000000" w:csb0="0002009F" w:csb1="00000000"/></w:font><w:font w:name="Times New Roman"><w:panose1 w:val="02020603050405020304"/><w:charset w:val="00"/><w:family w:val="roman"/><w:pitch w:val="variable"/><w:sig w:usb0="E0002AFF" w:usb1="C0007841" w:usb2="00000009" w:usb3="00000000" w:csb0="000001FF" w:csb1="00000000"/></w:font><w:font w:name="Cambria"><w:panose1 w:val="02040503050406030204"/><w:charset w:val="00"/><w:family w:val="roman"/><w:pitch w:val="variable"/><w:sig w:usb0="E00002FF" w:usb1="400004FF" w:usb2="00000000" w:usb3="00000000" w:csb0="0000019F" w:csb1="00000000"/></w:font><w:font w:name="Arial"><w:panose1 w:val="020B0604020202020204"/><w:charset w:val="00"/><w:family w:val="swiss"/><w:pitch w:val="variable"/><w:sig w:usb0="E0002AFF" w:usb1="C0007843" w:usb2="00000009" w:usb3="00000000" w:csb0="000001FF" w:csb1="00000000"/></w:font><w:font w:name="Calibri"><w:panose1 w:val="020F0502020204030204"/><w:charset w:val="00"/><w:family w:val="swiss"/><w:pitch w:val="variable"/><w:sig w:usb0="E00002FF" w:usb1="4000ACFF" w:usb2="00000001" w:usb3="00000000" w:csb0="0000019F" w:csb1="00000000"/></w:font><w:font w:name="ＭＳ Ｐ明朝"><w:panose1 w:val="02020600040205080304"/><w:charset w:val="80"/><w:family w:val="roman"/><w:pitch w:val="variable"/><w:sig w:usb0="E00002FF" w:usb1="6AC7FDFB" w:usb2="00000012" w:usb3="00000000" w:csb0="0002009F" w:csb1="00000000"/></w:font><w:font w:name="ＭＳ ゴシック"><w:altName w:val="MS Gothic"/><w:panose1 w:val="020B0609070205080204"/><w:charset w:val="80"/><w:family w:val="modern"/><w:pitch w:val="fixed"/><w:sig w:usb0="E00002FF" w:usb1="6AC7FDFB" w:usb2="00000012" w:usb3="00000000" w:csb0="0002009F" w:csb1="00000000"/></w:font><w:font w:name="Century"><w:panose1 w:val="02040604050505020304"/><w:charset w:val="00"/><w:family w:val="roman"/><w:pitch w:val="variable"/><w:sig w:usb0="00000287" w:usb1="00000000" w:usb2="00000000" w:usb3="00000000" w:csb0="0000009F" w:csb1="00000000"/></w:font></w:fonts></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/docProps/core.xml" pkg:contentType="application/vnd.openxmlformats-package.core-properties+xml" pkg:padding="256"><pkg:xmlData><cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:creator>ScenarioWriterCafe</dc:creator><cp:lastModifiedBy>ScenarioWriterCafe</cp:lastModifiedBy><cp:revision>2</cp:revision><dcterms:created xsi:type="dcterms:W3CDTF">2015-12-08T01:16:00Z</dcterms:created><dcterms:modified xsi:type="dcterms:W3CDTF">2015-12-08T01:16:00Z</dcterms:modified></cp:coreProperties></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/numbering.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml"><pkg:xmlData><w:numbering mc:Ignorable="w14 wp14" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"><w:abstractNum w:abstractNumId="0"><w:nsid w:val="01BF2CE0"/><w:multiLevelType w:val="multilevel"/><w:tmpl w:val="04906B6A"/><w:lvl w:ilvl="0"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%1."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="2992" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="1"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%2."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="3712" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="2"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%3."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="4432" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="3"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%4."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5152" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="4"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%5."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5872" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="5"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%6."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="6592" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="6"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%7."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="7312" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="7"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%8."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="8032" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="8"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%9."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="8752" w:hanging="180"/></w:pPr></w:lvl></w:abstractNum><w:abstractNum w:abstractNumId="1"><w:nsid w:val="5F6749AD"/><w:multiLevelType w:val="multilevel"/><w:tmpl w:val="04906B6A"/><w:lvl w:ilvl="0"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%1."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="2992" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="1"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%2."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="3712" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="2"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%3."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="4432" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="3"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%4."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5152" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="4"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%5."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5872" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="5"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%6."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="6592" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="6"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%7."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="7312" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="7"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%8."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="8032" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="8"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%9."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="8752" w:hanging="180"/></w:pPr></w:lvl></w:abstractNum><w:abstractNum w:abstractNumId="2"><w:nsid w:val="77B52296"/><w:multiLevelType w:val="hybridMultilevel"/><w:tmpl w:val="F6C45BDA"/><w:lvl w:ilvl="0" w:tplc="4904826E"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:pStyle w:val="a"/><w:lvlText w:val="%1."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="1420" w:hanging="360"/></w:pPr><w:rPr><w:rFonts w:ascii="ＭＳ 明朝" w:eastAsia="ＭＳ 明朝" w:hAnsi="ＭＳ 明朝" w:hint="eastAsia"/></w:rPr></w:lvl><w:lvl w:ilvl="1" w:tplc="04090019" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%2."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="3712" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="2" w:tplc="0409001B" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%3."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="4432" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="3" w:tplc="0409000F" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%4."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5152" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="4" w:tplc="04090019" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%5."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="5872" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="5" w:tplc="0409001B" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%6."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="6592" w:hanging="180"/></w:pPr></w:lvl><w:lvl w:ilvl="6" w:tplc="0409000F" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="decimal"/><w:lvlText w:val="%7."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="7312" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="7" w:tplc="04090019" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerLetter"/><w:lvlText w:val="%8."/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="8032" w:hanging="360"/></w:pPr></w:lvl><w:lvl w:ilvl="8" w:tplc="0409001B" w:tentative="1"><w:start w:val="1"/><w:numFmt w:val="lowerRoman"/><w:lvlText w:val="%9."/><w:lvlJc w:val="right"/><w:pPr><w:ind w:left="8752" w:hanging="180"/></w:pPr></w:lvl></w:abstractNum><w:num w:numId="1"><w:abstractNumId w:val="2"/></w:num><w:num w:numId="2"><w:abstractNumId w:val="1"/></w:num><w:num w:numId="3"><w:abstractNumId w:val="0"/></w:num></w:numbering></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/word/webSettings.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.wordprocessingml.webSettings+xml"><pkg:xmlData><w:webSettings mc:Ignorable="w14" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"><w:allowPNG/><w:pixelsPerInch w:val="72"/></w:webSettings></pkg:xmlData></pkg:part>
	<pkg:part pkg:name="/docProps/app.xml" pkg:contentType="application/vnd.openxmlformats-officedocument.extended-properties+xml" pkg:padding="256"><pkg:xmlData><Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"><Template>Script.Template.A4.Yoko.dot</Template><TotalTime>0</TotalTime><Pages>10</Pages><Words>615</Words><Characters>3510</Characters><Application>Microsoft Office Word</Application><DocSecurity>0</DocSecurity><Lines>29</Lines><Paragraphs>8</Paragraphs><ScaleCrop>false</ScaleCrop><HeadingPairs><vt:vector size="6" baseType="variant"><vt:variant><vt:lpstr>タイトル</vt:lpstr></vt:variant><vt:variant><vt:i4>1</vt:i4></vt:variant><vt:variant><vt:lpstr>Title</vt:lpstr></vt:variant><vt:variant><vt:i4>1</vt:i4></vt:variant><vt:variant><vt:lpstr>Headings</vt:lpstr></vt:variant><vt:variant><vt:i4>8</vt:i4></vt:variant></vt:vector></HeadingPairs><Company>deerstudio</Company><LinksUpToDate>false</LinksUpToDate><CharactersWithSpaces>4117</CharactersWithSpaces><SharedDoc>false</SharedDoc><HyperlinksChanged>false</HyperlinksChanged><AppVersion>14.0000</AppVersion></Properties></pkg:xmlData></pkg:part>
</pkg:package>
END_OF_XML;
					
	return	$ReturnXML;
}
