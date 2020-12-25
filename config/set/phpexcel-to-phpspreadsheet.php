<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\PHPOffice\Rector\MethodCall\ChangeConditionalGetConditionRector;
use Rector\PHPOffice\Rector\MethodCall\ChangeConditionalReturnedCellRector;
use Rector\PHPOffice\Rector\MethodCall\ChangeConditionalSetConditionRector;
use Rector\PHPOffice\Rector\MethodCall\ChangeDuplicateStyleArrayToApplyFromArrayRector;
use Rector\PHPOffice\Rector\MethodCall\GetDefaultStyleToGetParentRector;
use Rector\PHPOffice\Rector\MethodCall\IncreaseColumnIndexRector;
use Rector\PHPOffice\Rector\MethodCall\RemoveSetTempDirOnExcelWriterRector;
use Rector\PHPOffice\Rector\StaticCall\AddRemovedDefaultValuesRector;
use Rector\PHPOffice\Rector\StaticCall\CellStaticToCoordinateRector;
use Rector\PHPOffice\Rector\StaticCall\ChangeChartRendererRector;
use Rector\PHPOffice\Rector\StaticCall\ChangeDataTypeForValueRector;
use Rector\PHPOffice\Rector\StaticCall\ChangeIOFactoryArgumentRector;
use Rector\PHPOffice\Rector\StaticCall\ChangePdfWriterRector;
use Rector\PHPOffice\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md
# inspired https://github.com/PHPOffice/PhpSpreadsheet/blob/87f71e1930b497b36e3b9b1522117dfa87096d2b/src/PhpSpreadsheet/Helper/Migrator.php
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPOffice\Rector\StaticCall\ChangeIOFactoryArgumentRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\CellStaticToCoordinateRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\ChangeDataTypeForValueRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\ChangePdfWriterRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\ChangeChartRendererRector::class);
    $services->set(\Rector\PHPOffice\Rector\StaticCall\AddRemovedDefaultValuesRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\ChangeConditionalReturnedCellRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\ChangeConditionalGetConditionRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\ChangeConditionalSetConditionRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\RemoveSetTempDirOnExcelWriterRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\ChangeDuplicateStyleArrayToApplyFromArrayRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\GetDefaultStyleToGetParentRector::class);
    $services->set(\Rector\PHPOffice\Rector\MethodCall\IncreaseColumnIndexRector::class);
    # beware! this can be run only once, since its circular change
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#worksheetsetsharedstyle
        new \Rector\Renaming\ValueObject\MethodCallRename('PHPExcel_Worksheet', 'setSharedStyle', 'duplicateStyle'),
        // https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#worksheetgetselectedcell
        new \Rector\Renaming\ValueObject\MethodCallRename('PHPExcel_Worksheet', 'getSelectedCell', 'getSelectedCells'),
        // https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#cell-caching
        new \Rector\Renaming\ValueObject\MethodCallRename('PHPExcel_Worksheet', 'getCellCacheController', 'getCellCollection'),
        new \Rector\Renaming\ValueObject\MethodCallRename('PHPExcel_Worksheet', 'getCellCollection', 'getCoordinates'),
    ])]]);
    $configuration = [new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Shared_Date', 'ExcelToPHP', 'PHPExcel_Shared_Date', 'excelToTimestamp'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Shared_Date', 'ExcelToPHPObject', 'PHPExcel_Shared_Date', 'excelToDateTimeObject'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Shared_Date', 'FormattedPHPToExcel', 'PHPExcel_Shared_Date', 'formattedPHPToExcel'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Calculation_DateTime', 'DAYOFWEEK', 'PHPExcel_Calculation_DateTime', 'WEEKDAY'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Calculation_DateTime', 'WEEKOFYEAR', 'PHPExcel_Calculation_DateTime', 'WEEKNUCM'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Calculation_DateTime', 'SECONDOFMINUTE', 'PHPExcel_Calculation_DateTime', 'SECOND'), new \Rector\Renaming\ValueObject\RenameStaticMethod('PHPExcel_Calculation_DateTime', 'MINUTEOFHOUR', 'PHPExcel_Calculation_DateTime', 'MINUTE')];
    $services->set(\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHPExcel' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Spreadsheet', 'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DggContainer\\BstoreContainer\\BSE\\Blip', 'PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DgContainer\\SpgrContainer\\SpContainer', 'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DggContainer\\BstoreContainer\\BSE', 'PHPExcel_Shared_Escher_DgContainer_SpgrContainer' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DgContainer\\SpgrContainer', 'PHPExcel_Shared_Escher_DggContainer_BstoreContainer' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DggContainer\\BstoreContainer', 'PHPExcel_Shared_OLE_PPS_File' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLE\\PPS\\File', 'PHPExcel_Shared_OLE_PPS_Root' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLE\\PPS\\Root', 'PHPExcel_Worksheet_AutoFilter_Column_Rule' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\AutoFilter\\Column\\Rule', 'PHPExcel_Writer_OpenDocument_Cell_Comment' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Cell\\Comment', 'PHPExcel_Calculation_Token_Stack' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Token\\Stack', 'PHPExcel_Chart_Renderer_jpgraph' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Renderer\\JpGraph', 'PHPExcel_Reader_Excel5_Escher' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xls\\Escher', 'PHPExcel_Reader_Excel5_MD5' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xls\\MD5', 'PHPExcel_Reader_Excel5_RC4' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xls\\RC4', 'PHPExcel_Reader_Excel2007_Chart' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xlsx\\Chart', 'PHPExcel_Reader_Excel2007_Theme' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xlsx\\Theme', 'PHPExcel_Shared_Escher_DgContainer' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DgContainer', 'PHPExcel_Shared_Escher_DggContainer' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher\\DggContainer', 'CholeskyDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\CholeskyDecomposition', 'EigenvalueDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\EigenvalueDecomposition', 'PHPExcel_Shared_JAMA_LUDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\LUDecomposition', 'PHPExcel_Shared_JAMA_Matrix' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\Matrix', 'QRDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\QRDecomposition', 'PHPExcel_Shared_JAMA_QRDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\QRDecomposition', 'SingularValueDecomposition' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\JAMA\\SingularValueDecomposition', 'PHPExcel_Shared_OLE_ChainedBlockStream' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLE\\ChainedBlockStream', 'PHPExcel_Shared_OLE_PPS' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLE\\PPS', 'PHPExcel_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\BestFit', 'PHPExcel_Exponential_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\ExponentialBestFit', 'PHPExcel_Linear_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\LinearBestFit', 'PHPExcel_Logarithmic_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\LogarithmicBestFit', 'polynomialBestFit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\PolynomialBestFit', 'PHPExcel_Polynomial_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\PolynomialBestFit', 'powerBestFit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\PowerBestFit', 'PHPExcel_Power_Best_Fit' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\PowerBestFit', 'trendClass' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Trend\\Trend', 'PHPExcel_Worksheet_AutoFilter_Column' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\AutoFilter\\Column', 'PHPExcel_Worksheet_Drawing_Shadow' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Drawing\\Shadow', 'PHPExcel_Writer_OpenDocument_Content' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Content', 'PHPExcel_Writer_OpenDocument_Meta' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Meta', 'PHPExcel_Writer_OpenDocument_MetaInf' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\MetaInf', 'PHPExcel_Writer_OpenDocument_Mimetype' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Mimetype', 'PHPExcel_Writer_OpenDocument_Settings' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Settings', 'PHPExcel_Writer_OpenDocument_Styles' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Styles', 'PHPExcel_Writer_OpenDocument_Thumbnails' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\Thumbnails', 'PHPExcel_Writer_OpenDocument_WriterPart' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods\\WriterPart', 'PHPExcel_Writer_PDF_Core' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf', 'PHPExcel_Writer_PDF_DomPDF' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf\\Dompdf', 'PHPExcel_Writer_PDF_mPDF' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf\\Mpdf', 'PHPExcel_Writer_PDF_tcPDF' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf\\Tcpdf', 'PHPExcel_Writer_Excel5_BIFFwriter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\BIFFwriter', 'PHPExcel_Writer_Excel5_Escher' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Escher', 'PHPExcel_Writer_Excel5_Font' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Font', 'PHPExcel_Writer_Excel5_Parser' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Parser', 'PHPExcel_Writer_Excel5_Workbook' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Workbook', 'PHPExcel_Writer_Excel5_Worksheet' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Worksheet', 'PHPExcel_Writer_Excel5_Xf' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls\\Xf', 'PHPExcel_Writer_Excel2007_Chart' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Chart', 'PHPExcel_Writer_Excel2007_Comments' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Comments', 'PHPExcel_Writer_Excel2007_ContentTypes' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\ContentTypes', 'PHPExcel_Writer_Excel2007_DocProps' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\DocProps', 'PHPExcel_Writer_Excel2007_Drawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Drawing', 'PHPExcel_Writer_Excel2007_Rels' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Rels', 'PHPExcel_Writer_Excel2007_RelsRibbon' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\RelsRibbon', 'PHPExcel_Writer_Excel2007_RelsVBA' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\RelsVBA', 'PHPExcel_Writer_Excel2007_StringTable' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\StringTable', 'PHPExcel_Writer_Excel2007_Style' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Style', 'PHPExcel_Writer_Excel2007_Theme' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Theme', 'PHPExcel_Writer_Excel2007_Workbook' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Workbook', 'PHPExcel_Writer_Excel2007_Worksheet' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\Worksheet', 'PHPExcel_Writer_Excel2007_WriterPart' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx\\WriterPart', 'PHPExcel_CachedObjectStorage_CacheBase' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Collection\\Cells', 'PHPExcel_CalcEngine_CyclicReferenceStack' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Engine\\CyclicReferenceStack', 'PHPExcel_CalcEngine_Logger' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Engine\\Logger', 'PHPExcel_Calculation_Functions' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Functions', 'PHPExcel_Calculation_Function' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Category', 'PHPExcel_Calculation_Database' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Database', 'PHPExcel_Calculation_DateTime' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\DateTime', 'PHPExcel_Calculation_Engineering' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Engineering', 'PHPExcel_Calculation_Exception' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Exception', 'PHPExcel_Calculation_ExceptionHandler' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\ExceptionHandler', 'PHPExcel_Calculation_Financial' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Financial', 'PHPExcel_Calculation_FormulaParser' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\FormulaParser', 'PHPExcel_Calculation_FormulaToken' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\FormulaToken', 'PHPExcel_Calculation_Logical' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Logical', 'PHPExcel_Calculation_LookupRef' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\LookupRef', 'PHPExcel_Calculation_MathTrig' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\MathTrig', 'PHPExcel_Calculation_Statistical' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Statistical', 'PHPExcel_Calculation_TextData' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\TextData', 'PHPExcel_Cell_AdvancedValueBinder' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\AdvancedValueBinder', 'PHPExcel_Cell_DataType' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\DataType', 'PHPExcel_Cell_DataValidation' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\DataValidation', 'PHPExcel_Cell_DefaultValueBinder' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\DefaultValueBinder', 'PHPExcel_Cell_Hyperlink' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\Hyperlink', 'PHPExcel_Cell_IValueBinder' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\IValueBinder', 'PHPExcel_Chart_Axis' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Axis', 'PHPExcel_Chart_DataSeries' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\DataSeries', 'PHPExcel_Chart_DataSeriesValues' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\DataSeriesValues', 'PHPExcel_Chart_Exception' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Exception', 'PHPExcel_Chart_GridLines' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\GridLines', 'PHPExcel_Chart_Layout' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Layout', 'PHPExcel_Chart_Legend' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Legend', 'PHPExcel_Chart_PlotArea' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\PlotArea', 'PHPExcel_Properties' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Properties', 'PHPExcel_Chart_Title' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Title', 'PHPExcel_DocumentProperties' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Document\\Properties', 'PHPExcel_DocumentSecurity' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Document\\Security', 'PHPExcel_Helper_HTML' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Helper\\Html', 'PHPExcel_Reader_Abstract' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\BaseReader', 'PHPExcel_Reader_CSV' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Csv', 'PHPExcel_Reader_DefaultReadFilter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\DefaultReadFilter', 'PHPExcel_Reader_Excel2003XML' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xml', 'PHPExcel_Reader_Exception' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Exception', 'PHPExcel_Reader_Gnumeric' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Gnumeric', 'PHPExcel_Reader_HTML' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Html', 'PHPExcel_Reader_IReadFilter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\IReadFilter', 'PHPExcel_Reader_IReader' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\IReader', 'PHPExcel_Reader_OOCalc' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Ods', 'PHPExcel_Reader_SYLK' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Slk', 'PHPExcel_Reader_Excel5' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xls', 'PHPExcel_Reader_Excel2007' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Reader\\Xlsx', 'PHPExcel_RichText_ITextElement' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\RichText\\ITextElement', 'PHPExcel_RichText_Run' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\RichText\\Run', 'PHPExcel_RichText_TextElement' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\RichText\\TextElement', 'PHPExcel_Shared_CodePage' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\CodePage', 'PHPExcel_Shared_Date' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Date', 'PHPExcel_Shared_Drawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Drawing', 'PHPExcel_Shared_Escher' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Escher', 'PHPExcel_Shared_File' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\File', 'PHPExcel_Shared_Font' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Font', 'PHPExcel_Shared_OLE' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLE', 'PHPExcel_Shared_OLERead' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\OLERead', 'PHPExcel_Shared_PasswordHasher' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\PasswordHasher', 'PHPExcel_Shared_String' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\StringHelper', 'PHPExcel_Shared_TimeZone' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\TimeZone', 'PHPExcel_Shared_XMLWriter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\XMLWriter', 'PHPExcel_Shared_Excel5' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Shared\\Xls', 'PHPExcel_Style_Alignment' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Alignment', 'PHPExcel_Style_Border' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Border', 'PHPExcel_Style_Borders' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Borders', 'PHPExcel_Style_Color' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Color', 'PHPExcel_Style_Conditional' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Conditional', 'PHPExcel_Style_Fill' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Fill', 'PHPExcel_Style_Font' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Font', 'PHPExcel_Style_NumberFormat' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\NumberFormat', 'PHPExcel_Style_Protection' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Protection', 'PHPExcel_Style_Supervisor' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Supervisor', 'PHPExcel_Worksheet_AutoFilter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\AutoFilter', 'PHPExcel_Worksheet_BaseDrawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\BaseDrawing', 'PHPExcel_Worksheet_CellIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\CellIterator', 'PHPExcel_Worksheet_Column' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Column', 'PHPExcel_Worksheet_ColumnCellIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\ColumnCellIterator', 'PHPExcel_Worksheet_ColumnDimension' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\ColumnDimension', 'PHPExcel_Worksheet_ColumnIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\ColumnIterator', 'PHPExcel_Worksheet_Drawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Drawing', 'PHPExcel_Worksheet_HeaderFooter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\HeaderFooter', 'PHPExcel_Worksheet_HeaderFooterDrawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\HeaderFooterDrawing', 'PHPExcel_WorksheetIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Iterator', 'PHPExcel_Worksheet_MemoryDrawing' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\MemoryDrawing', 'PHPExcel_Worksheet_PageMargins' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\PageMargins', 'PHPExcel_Worksheet_PageSetup' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\PageSetup', 'PHPExcel_Worksheet_Protection' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Protection', 'PHPExcel_Worksheet_Row' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Row', 'PHPExcel_Worksheet_RowCellIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\RowCellIterator', 'PHPExcel_Worksheet_RowDimension' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\RowDimension', 'PHPExcel_Worksheet_RowIterator' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\RowIterator', 'PHPExcel_Worksheet_SheetView' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\SheetView', 'PHPExcel_Writer_Abstract' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\BaseWriter', 'PHPExcel_Writer_CSV' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Csv', 'PHPExcel_Writer_Exception' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Exception', 'PHPExcel_Writer_HTML' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Html', 'PHPExcel_Writer_IWriter' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\IWriter', 'PHPExcel_Writer_OpenDocument' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Ods', 'PHPExcel_Writer_PDF' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Pdf', 'PHPExcel_Writer_Excel5' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xls', 'PHPExcel_Writer_Excel2007' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Writer\\Xlsx', 'PHPExcel_CachedObjectStorageFactory' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Collection\\CellsFactory', 'PHPExcel_Calculation' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Calculation\\Calculation', 'PHPExcel_Cell' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Cell\\Cell', 'PHPExcel_Chart' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Chart\\Chart', 'PHPExcel_Comment' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Comment', 'PHPExcel_Exception' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Exception', 'PHPExcel_HashTable' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\HashTable', 'PHPExcel_IComparable' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\IComparable', 'PHPExcel_IOFactory' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\IOFactory', 'PHPExcel_NamedRange' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\NamedRange', 'PHPExcel_ReferenceHelper' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\ReferenceHelper', 'PHPExcel_RichText' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\RichText\\RichText', 'PHPExcel_Settings' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Settings', 'PHPExcel_Style' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Style\\Style', 'PHPExcel_Worksheet' => '_PhpScoper8b9c402c5f32\\PhpOffice\\PhpSpreadsheet\\Worksheet\\Worksheet']]]);
};
