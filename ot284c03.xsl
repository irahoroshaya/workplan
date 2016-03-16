<?xml version="1.0" encoding="koi8-r"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:fo="http://www.w3.org/1999/XSL/Format">
<xsl:output method="xml" indent="yes" encoding="koi8-r"/>

<xsl:variable name="border-width" select="0.1" />
<xsl:variable name="_kol" select="1" />
<xsl:variable name="font-size" select="12" />
<xsl:variable name="_p_d" select="ot284c03/p_d" />
<xsl:variable name="_p704" select="ot284c03/p704" />
<xsl:variable name="_fio" select="ot284c03/fio" />
<xsl:variable name="_x453" select="ot284c03/x453" />
<xsl:variable name="_x459" select="ot284c03/x459" />
<xsl:variable name="_date" select="ot284c03/date" />

<xsl:template match="ot284c03">

  <fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <fo:layout-master-set>
		<fo:simple-page-master master-name="A4" 
	   	 page-width="297mm" margin-left="10mm" margin-right="10mm"
	    	 page-height="210mm" margin-top="5mm" margin-bottom="5mm">
	    	<fo:region-before extent="15mm"   />
			<fo:region-body  margin-top="16mm" margin-bottom="16mm" />
			<fo:region-after extent="15mm" />
		</fo:simple-page-master>
    </fo:layout-master-set>

    
	<fo:page-sequence master-reference="A4" initial-page-number="1">
	
	<fo:static-content flow-name="xsl-region-before"
		  	       font-family="Times" font-size="8pt" 
			       text-align="left">
	<xsl:call-template name="f_start_list"/>
	</fo:static-content>

	<fo:flow flow-name="xsl-region-body"
    		 font-family="Times" font-size="9pt">
    		 
              <xsl:call-template name="zag" />		     	
<!-- *****************документ****************** -->                
    <fo:block id="end" />         	       	             
   	</fo:flow>
   </fo:page-sequence>
    
  </fo:root>
</xsl:template>
<!--***********************************************************************-->
<xsl:template name="f_start_list">

<fo:table>
<fo:table-column column-width="220mm"/>
<fo:table-column column-width="60mm"/>    
    
<fo:table-body text-align='right'>
    <fo:table-row>
    <fo:table-cell>
    <fo:block></fo:block>
       	</fo:table-cell>

    <fo:table-cell font-size="8pt">
	<fo:block>OT284C03</fo:block>
	<fo:block>Лист <fo:page-number /> / Листов <fo:page-number-citation ref-id="end" /></fo:block>
	<fo:block ><xsl:value-of select="$_p_d" /></fo:block>
	<fo:block> </fo:block>
</fo:table-cell>
</fo:table-row>
</fo:table-body>

</fo:table>

</xsl:template>
<!--  **************************строки*****************************-->
<xsl:template match="str">
  <fo:table-row keep-together="always">
	    <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="num" /></fo:block>
            </fo:table-cell>
	     <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="x36302" /> - <xsl:value-of select="x36303" /></fo:block>
		</fo:table-cell>
		 <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="p006" /></fo:block>
                <fo:block ><xsl:value-of select="p008" /></fo:block>
            </fo:table-cell>
		 <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="p016" /> - <xsl:value-of select="p017" /></fo:block>
                <fo:block ><xsl:value-of select="x745" /></fo:block>
            </fo:table-cell>
		 <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="x684" /></fo:block>
            </fo:table-cell>
		 <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="c164" /></fo:block>
            </fo:table-cell>
		 <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="prof" /></fo:block>
            </fo:table-cell>
                  <fo:table-cell border-style="solid"
                            border-width="1pt">
                <fo:block ><xsl:value-of select="oborud" /></fo:block>
                <fo:block ><xsl:value-of select="inv" /></fo:block>
            </fo:table-cell>
	  </fo:table-row>
</xsl:template>

<!--***********************************************************************-->
<xsl:template name="zag">
   
       <fo:table text-align="center" 
                font-weight="normal"
                font-size="10pt"
                display-align="center">
<fo:table-column column-width="40mm"/>
<fo:table-column column-width="90mm"/>
<fo:table-column column-width="40mm"/>
<fo:table-column column-width="20mm"/>
<fo:table-column column-width="20mm"/>
<fo:table-column column-width="70mm"/>


<fo:table-body text-align='center' 
               font-size="12pt" >
    <fo:table-row><fo:table-cell text-align='left' font-weight="bold"><fo:block>Сменное задание</fo:block><fo:block>&#160;</fo:block></fo:table-cell>
        <fo:table-cell><fo:block><xsl:value-of select="$_fio" /></fo:block><fo:block>&#160;</fo:block></fo:table-cell>
        <fo:table-cell><fo:block>т.н. <xsl:value-of select="$_p704" /></fo:block><fo:block>&#160;</fo:block></fo:table-cell>
        <fo:table-cell><fo:block>цех <xsl:value-of select="$_x453" /></fo:block><fo:block>&#160;</fo:block></fo:table-cell>
        <fo:table-cell><fo:block>участок <xsl:value-of select="$_x459" /></fo:block><fo:block>&#160;</fo:block></fo:table-cell>
        <fo:table-cell><fo:block text-align='right'>Дата задания <xsl:value-of select="$_date" /></fo:block><fo:block>&#160;</fo:block></fo:table-cell>
 </fo:table-row></fo:table-body>
    </fo:table>
       
       
    <fo:table text-align="center" 
                font-weight="normal"
                font-size="12pt"
                display-align="center">
<fo:table-column column-width="8mm"/>
<fo:table-column column-width="23mm"/>
<fo:table-column column-width="40mm"/>
<fo:table-column column-width="64mm"/>
<fo:table-column column-width="25mm"/>
<fo:table-column column-width="15mm"/>
<fo:table-column column-width="45mm"/>
<fo:table-column column-width="60mm"/>

<fo:table-header>
    <fo:table-row>
        <fo:table-cell border-style="solid" ><fo:block>&#8470; п/п</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Время</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Обозначение, наименование</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Операция</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Номера СП</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Кол-во</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Профессия</fo:block></fo:table-cell>
        <fo:table-cell border-style="solid" ><fo:block>Оборудование</fo:block></fo:table-cell>
    </fo:table-row>
</fo:table-header>    

<fo:table-body text-align='center' font-size="10pt">
    <xsl:apply-templates select="..//str"/>
</fo:table-body>
    </fo:table>
</xsl:template>

</xsl:stylesheet>

