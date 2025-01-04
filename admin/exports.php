<?php
function cs_win2ascii($s){
    return strtr($s,
        "\xe1\xe4\xe8\xef\xe9\xec\xed\xbe\xe5\xf2\xf3\xf6\xf5\xf4\xf8\xe0\x9a\x9d\xfa\xf9\xfc\xfb\xfd\x9e\xc1\xc4\xc8\xcf\xc9\xcc\xcd\xbc\xc5\xd2\xd3\xd6\xd5\xd4\xd8\xc0\x8a\x8d\xda\xd9\xdc\xdb\xdd\x8e",
        "aacdeeillnoooorrstuuuuyzAACDEEILLNOOOORRSTUUUUYZ"
    );
}

$xml=$_GET["xml"];
if ($xml=="1") {
  $xml=true;
} else {
  $xml=false;
}

$sumaZaplaceno=Array();

if ($xml) {
  if (!file_exists('./xml')) {
    mkdir('./xml', 0777, true);
  }
  unlink('./xml/ENROLLED.XML');
  unlink('./xml/MEMBER.XML');

  $member="";
  $enrolled="";
  $csvData="";

// vybereme zavodniky, kteri zaplatitli nebo jsou v prematchi nebo rozhodci nebo nemusí platit
    $query="select * from $table where Squad>=0 AND (Zaplaceno='on' OR RO='on' OR VIP='on') ORDER BY Cislo;";

  $strelci=mysql_query($query);
  while ($z=mysql_fetch_array($strelci)) {
    $Female="False";
    $DivId=0;
    $CatId=0;
    $MajorPF="False";
    $SquadId=$z[Squad];
    $TagId="0";
    if ($SquadId=="0") {
      $SquadId=0;
      $TagId="0";
      $SquadStr='0';
    } else {
      $SquadStr="$SquadId";
    }
    if ($z[Pifak]=="MAJ") {
      $MajorPF="True";
    }
    switch ($z[Pidiv]) {
      case "OPN":
        $DivId=1;
      break;
      case "STD":
        $DivId=2;
      break;
      case "MOD":
        $DivId=3;
      break;
      case "PRD":
        $DivId=4;
        $MajorPF="False";
      break;
      case "REV":
        $DivId=5;
      break;
      case "CLA":
        $DivId=18;
      break;
      case "PCC":
        $DivId=27;
        $MajorPF="False";
      break;
      case "PDO":
        $DivId=24;
        $MajorPF="False";
      break;
      DEFAULT:
        $DivId=1;
      break;  
    }
    switch ($z[Kategorie]) {
      case "REGULAR":
        $CatId=0;
      break;
      case "SENIOR":
        $CatId=3;
      break;
      case "SSENIOR":
        $CatId=4;
      break;
      case "LADY":
        $CatId=1;
      break;
      case "JUNIOR":
        $CatId=2;
      break;
      DEFAULT:
        $CatId=0;
      break;  
    }
    switch ($z[Zaplaceno]) {
      case "on":
        $Zaplaceno="Zaplaceno";
      break;
      DEFAULT:
        $Zaplaceno="";
      break;  
    }
       
    $member.="	<z:row MemberId='$z[Cislo]' Lastname='$z[Prijmeni]' Firstname='$z[Jmeno]' IcsAlias='$z[Alias]' InActive='False' Female='$Female' PrintLabel='False' RegionId='$z[Region]' DOB='1990-01-01T00:00:00' Email='$z[Mail]' ClassId='U' DfltDivId='0' DfltCatId='0' DfltTagId='0' QualId='0' Register='False'/>
";

    $enrolled.="	<z:row MatchId='1' MemberId='$z[Cislo]' CompId='$z[Cislo]' DivId='$DivId' CatId='$CatId' TeamId='0' SquadId='$SquadId' TagId='$TagId' MajorPF='$MajorPF' Classified='False' IsDisq='False' DisqRuleId='0' StageDisq='False'/>
";
    $csvData.="$z[Cislo];$z[Jmeno];$z[Prijmeni];$z[Mail];$z[Region];$z[Alias];$z[Pidiv];$z[Kategorie];$z[Pifak];$SquadStr"."\r\n";
  
  }

  $fh = fopen('./xml/MEMBER.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MemberId\' rs:number=\'1\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'MemberId\' rs:keycolumn=\'true\' rs:autoincrement=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Lastname\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'Lastname\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'25\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Firstname\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'Firstname\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'15\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Init\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'Comment\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'1\'/>
		</s:AttributeType>
		<s:AttributeType name=\'IcsAlias\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'ICS\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'16\'/>
		</s:AttributeType>
		<s:AttributeType name=\'RefNo\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'RefNo\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'10\'/>
		</s:AttributeType>
		<s:AttributeType name=\'InActive\' rs:number=\'7\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'InActive\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Female\' rs:number=\'8\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'Female\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PrintLabel\' rs:number=\'9\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'PrintLabel\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'RegionId\' rs:number=\'10\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'TypeRegionId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DOB\' rs:number=\'11\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'DOB\'>
			<s:datatype dt:type=\'dateTime\' rs:dbtype=\'variantdate\' dt:maxLength=\'16\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Address1\' rs:number=\'12\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'Address1\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Address2\' rs:number=\'13\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'Address2\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'City\' rs:number=\'14\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'City\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Province\' rs:number=\'15\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'Province\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'24\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CountryId\' rs:number=\'16\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'TypeCountryId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PostCode\' rs:number=\'17\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'PostCode\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'10\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PhoneHome\' rs:number=\'18\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'PhoneHome\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PhoneAlt\' rs:number=\'19\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'PhoneAlternate\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PhoneFax\' rs:number=\'20\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'PhoneFax\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Email\' rs:number=\'21\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'Email\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'36\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ClassId\' rs:number=\'22\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'TypeScoreClassId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'1\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DfltDivId\' rs:number=\'23\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'DfltDivisionId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DfltCatId\' rs:number=\'24\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'DfltNonTeamCategoryId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DfltTagId\' rs:number=\'25\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'DfltTagId\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'QualId\' rs:number=\'26\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMember\' rs:basecolumn=\'TypeQualificationId\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Register\' rs:number=\'27\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'Register\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Note\' rs:number=\'28\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMember\'
			 rs:basecolumn=\'Note\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'536870910\' rs:long=\'true\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
';
  $xmlData.=$member;
  $xmlData.='</rs:data>
</xml>
';
  fwrite($fh, $xmlData);
  fclose($fh);

  $fh = fopen('./xml/ENROLLED.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MemberId\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'MemberId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CompId\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'CompetitorId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DivId\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'TypeDivisionId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CatId\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'TypeNonTeamCategoryId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TeamId\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'TeamId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'SquadId\' rs:number=\'7\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'SquadId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TagId\' rs:number=\'8\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'TagId\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MajorPF\' rs:number=\'9\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'MajorPowerFactor\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Classified\' rs:number=\'10\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'ClassifiedScoring\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'IsDisq\' rs:number=\'11\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'IsDisqualified\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DisqRuleId\' rs:number=\'12\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'TypeDisqualifyRuleId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StageDisq\' rs:number=\'13\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'StageDisqualification\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DisqDt\' rs:number=\'14\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'DisqualifyDateTime\'>
			<s:datatype dt:type=\'dateTime\' rs:dbtype=\'variantdate\' dt:maxLength=\'16\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DisqMemo\' rs:number=\'15\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchCompetitor\' rs:basecolumn=\'DisqualifyMemo\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'536870910\' rs:long=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'RefNo\' rs:number=\'16\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchCompetitor\'
			 rs:basecolumn=\'RefNo\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'10\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
';

  $xmlData.=$enrolled;
  $xmlData.='</rs:data>
</xml>
';
  fwrite($fh, $xmlData);
  fclose($fh);

  $fh = fopen("./xml/".$table.'_shooter.csv', 'w');
  $xmlData="#;Given Name;Family Name;Email Address;Country of Residence;Team;IPSC Alias;type;Division;Category;Power Factor;Date of Birth;Mobile Phone;pass;status;ip_addr;reg_date;Squad;payment;reg_squad;pay_date;squad_date;j_id;registrace;active shooter;verify;verify2;Home Phone;Passport: Gender;Fast-Track PIN"."\r\n";
  $xmlData.=iconv("UTF-8", "Windows-1250", $csvData);
  fwrite($fh, $xmlData);
  fclose($fh);

  $fh = fopen('./xml/competitors_scoresheets.csv', 'w');
  $xmlData="#;Given Name;Family Name;Email Address;Country of Residence;IPSC Alias;Division;Category;Power Factor;Squad"."\r\n";

  $xmlData.=iconv("UTF-8", "Windows-1250", $csvData);
  fwrite($fh, $xmlData);
  fclose($fh);

  
  unlink('./xml/TAG.XML');
  $fh = fopen('./xml/TAG.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'TagId\' rs:number=\'1\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblTag\'
			 rs:basecolumn=\'TagId\' rs:keycolumn=\'true\' rs:autoincrement=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Tag\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblTag\'
			 rs:basecolumn=\'Tag\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
	<z:row TagId=\'1\' Tag=\'TAG\'/>
	<z:row TagId=\'2\' Tag=\'PRO\'/>
	<z:row TagId=\'3\' Tag=\'PSH\'/>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/CLASSIFY.XML');
  $fh = fopen('./xml/CLASSIFY.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MemberId\' rs:number=\'1\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMemberClassify\'
			 rs:basecolumn=\'MemberId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DivId\' rs:number=\'2\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMemberClassify\'
			 rs:basecolumn=\'TypeDivisionId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'IntlId\' rs:number=\'3\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMemberClassify\'
			 rs:basecolumn=\'TypeClassIntlId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'1\'/>
		</s:AttributeType>
		<s:AttributeType name=\'NatlId\' rs:number=\'4\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMemberClassify\'
			 rs:basecolumn=\'TypeClassNatlId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'1\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ClassId\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMemberClassify\' rs:basecolumn=\'TypeScoreClassId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'1\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/CLUB.XML');
  $fh = fopen('./xml/CLUB.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'ClubId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'ClubId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ClubCode\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'ClubCode\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'6\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Club\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblClub\'
			 rs:basecolumn=\'Club\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'50\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Contact\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'Contact\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'50\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Address1\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'Address1\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Address2\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'Address2\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'City\' rs:number=\'7\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblClub\'
			 rs:basecolumn=\'City\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Province\' rs:number=\'8\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'Province\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'24\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CountryId\' rs:number=\'9\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'TypeCountryId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PostCode\' rs:number=\'10\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'PostCode\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'10\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Phone\' rs:number=\'11\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblClub\'
			 rs:basecolumn=\'Phone\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PhoneAlt\' rs:number=\'12\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'PhoneAlternate\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'PhoneFax\' rs:number=\'13\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'PhoneFax\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'20\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Email\' rs:number=\'14\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblClub\'
			 rs:basecolumn=\'Email\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'36\'/>
		</s:AttributeType>
		<s:AttributeType name=\'WebSite\' rs:number=\'15\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblClub\' rs:basecolumn=\'WebSite\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'64\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
	<z:row ClubId=\'1\' Club=\'EXTREME SQUAD\'/>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/SCORE.XML');
  $fh = fopen('./xml/SCORE.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StageId\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'StageId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MemberId\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'MemberId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ScoreA\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'ScoreA\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ScoreB\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'ScoreB\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ScoreC\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'ScoreC\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ScoreD\' rs:number=\'7\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'ScoreD\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Misses\' rs:number=\'8\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'Misses\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Penalties\' rs:number=\'9\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'Penalties\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ProcError\' rs:number=\'10\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'Procedurals\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ShootTime\' rs:number=\'11\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'Time\'>
			<s:datatype dt:type=\'r4\' dt:maxLength=\'4\' rs:precision=\'7\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Remove\' rs:number=\'12\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'RemoveScoring\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Deduction\' rs:number=\'13\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'Deduction\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'FlagDelete\' rs:number=\'14\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'FlagForDelete\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'IsDisq\' rs:number=\'15\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'Disqualified\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DedPctg\' rs:number=\'16\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'DeductionPercent\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ExtraShot\' rs:number=\'17\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'ExtraShot\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'OverTime\' rs:number=\'18\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'OverTime\'>
			<s:datatype dt:type=\'r4\' dt:maxLength=\'4\' rs:precision=\'7\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'HitFactor\' rs:number=\'19\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'HitFactor\'>
			<s:datatype dt:type=\'r4\' dt:maxLength=\'4\' rs:precision=\'7\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'FinalScore\' rs:number=\'20\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'FinalScore\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'LastModify\' rs:number=\'21\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStageScore\' rs:basecolumn=\'LastModified\'>
			<s:datatype dt:type=\'dateTime\' rs:dbtype=\'variantdate\' dt:maxLength=\'16\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'NoVerify\' rs:number=\'22\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStageScore\'
			 rs:basecolumn=\'NoScoreVerify\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/SQUAD.XML');
  $fh = fopen('./xml/SQUAD.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchSquad\' rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'SquadId\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchSquad\' rs:basecolumn=\'SquadId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Squad\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchSquad\'
			 rs:basecolumn=\'Squad\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
	<z:row MatchId=\'1\' SquadId=\'0\' Squad=\'0\'/>
	<z:row MatchId=\'1\' SquadId=\'1\' Squad=\'1\'/>
	<z:row MatchId=\'1\' SquadId=\'2\' Squad=\'2\'/>
	<z:row MatchId=\'1\' SquadId=\'3\' Squad=\'3\'/>
	<z:row MatchId=\'1\' SquadId=\'4\' Squad=\'4\'/>
	<z:row MatchId=\'1\' SquadId=\'5\' Squad=\'5\'/>
	<z:row MatchId=\'1\' SquadId=\'6\' Squad=\'6\'/>
	<z:row MatchId=\'1\' SquadId=\'7\' Squad=\'7\'/>
	<z:row MatchId=\'1\' SquadId=\'8\' Squad=\'8\'/>
	<z:row MatchId=\'1\' SquadId=\'9\' Squad=\'9\'/>
	<z:row MatchId=\'1\' SquadId=\'10\' Squad=\'10\'/>
	<z:row MatchId=\'1\' SquadId=\'11\' Squad=\'11\'/>
	<z:row MatchId=\'1\' SquadId=\'12\' Squad=\'12\'/>
	<z:row MatchId=\'1\' SquadId=\'13\' Squad=\'13\'/>
	<z:row MatchId=\'1\' SquadId=\'14\' Squad=\'14\'/>
	<z:row MatchId=\'1\' SquadId=\'15\' Squad=\'15\'/>
	<z:row MatchId=\'1\' SquadId=\'16\' Squad=\'16\'/>
	<z:row MatchId=\'1\' SquadId=\'17\' Squad=\'17\'/>
	<z:row MatchId=\'1\' SquadId=\'18\' Squad=\'18\'/>
	<z:row MatchId=\'1\' SquadId=\'19\' Squad=\'19\'/>
	<z:row MatchId=\'1\' SquadId=\'20\' Squad=\'20\'/>
	<z:row MatchId=\'1\' SquadId=\'21\' Squad=\'21\'/>
	<z:row MatchId=\'1\' SquadId=\'22\' Squad=\'22\'/>
	<z:row MatchId=\'1\' SquadId=\'23\' Squad=\'23\'/>
	<z:row MatchId=\'1\' SquadId=\'24\' Squad=\'24\'/>
	<z:row MatchId=\'1\' SquadId=\'25\' Squad=\'25\'/>
	<z:row MatchId=\'1\' SquadId=\'26\' Squad=\'26\'/>
	<z:row MatchId=\'1\' SquadId=\'27\' Squad=\'27\'/>
	<z:row MatchId=\'1\' SquadId=\'28\' Squad=\'28\'/>
	<z:row MatchId=\'1\' SquadId=\'29\' Squad=\'29\'/>
	<z:row MatchId=\'1\' SquadId=\'30\' Squad=\'30\'/>
	<z:row MatchId=\'1\' SquadId=\'31\' Squad=\'31\'/>
	<z:row MatchId=\'1\' SquadId=\'32\' Squad=\'32\'/>
	<z:row MatchId=\'1\' SquadId=\'33\' Squad=\'33\'/>
	<z:row MatchId=\'1\' SquadId=\'34\' Squad=\'34\'/>
	<z:row MatchId=\'1\' SquadId=\'35\' Squad=\'35\'/>
	<z:row MatchId=\'1\' SquadId=\'36\' Squad=\'36\'/>
	<z:row MatchId=\'1\' SquadId=\'37\' Squad=\'37\'/>
	<z:row MatchId=\'1\' SquadId=\'38\' Squad=\'38\'/>
	<z:row MatchId=\'1\' SquadId=\'39\' Squad=\'39\'/>
	<z:row MatchId=\'1\' SquadId=\'40\' Squad=\'40\'/>
	<z:row MatchId=\'1\' SquadId=\'41\' Squad=\'41\'/>
	<z:row MatchId=\'1\' SquadId=\'42\' Squad=\'42\'/>
	<z:row MatchId=\'1\' SquadId=\'43\' Squad=\'43\'/>
	<z:row MatchId=\'1\' SquadId=\'44\' Squad=\'44\'/>
	<z:row MatchId=\'1\' SquadId=\'45\' Squad=\'45\'/>
	<z:row MatchId=\'1\' SquadId=\'46\' Squad=\'46\'/>
	<z:row MatchId=\'1\' SquadId=\'47\' Squad=\'47\'/>
	<z:row MatchId=\'1\' SquadId=\'48\' Squad=\'48\'/>
	<z:row MatchId=\'1\' SquadId=\'49\' Squad=\'49\'/>
	<z:row MatchId=\'1\' SquadId=\'50\' Squad=\'50\'/>
	<z:row MatchId=\'1\' SquadId=\'51\' Squad=\'51\'/>
	<z:row MatchId=\'1\' SquadId=\'52\' Squad=\'52\'/>
	<z:row MatchId=\'1\' SquadId=\'53\' Squad=\'53\'/>
	<z:row MatchId=\'1\' SquadId=\'54\' Squad=\'54\'/>
	<z:row MatchId=\'1\' SquadId=\'55\' Squad=\'55\'/>
	<z:row MatchId=\'1\' SquadId=\'56\' Squad=\'56\'/>
	<z:row MatchId=\'1\' SquadId=\'57\' Squad=\'57\'/>
	<z:row MatchId=\'1\' SquadId=\'58\' Squad=\'58\'/>
	<z:row MatchId=\'1\' SquadId=\'59\' Squad=\'59\'/>
	<z:row MatchId=\'1\' SquadId=\'60\' Squad=\'60\'/>
	<z:row MatchId=\'1\' SquadId=\'61\' Squad=\'61\'/>
	<z:row MatchId=\'1\' SquadId=\'62\' Squad=\'62\'/>
	<z:row MatchId=\'1\' SquadId=\'63\' Squad=\'63\'/>
	<z:row MatchId=\'1\' SquadId=\'64\' Squad=\'64\'/>
	<z:row MatchId=\'1\' SquadId=\'65\' Squad=\'65\'/>
	<z:row MatchId=\'1\' SquadId=\'66\' Squad=\'66\'/>
	<z:row MatchId=\'1\' SquadId=\'67\' Squad=\'67\'/>
	<z:row MatchId=\'1\' SquadId=\'68\' Squad=\'68\'/>
	<z:row MatchId=\'1\' SquadId=\'69\' Squad=\'69\'/>
	<z:row MatchId=\'1\' SquadId=\'70\' Squad=\'70\'/>
	<z:row MatchId=\'1\' SquadId=\'71\' Squad=\'71\'/>
	<z:row MatchId=\'1\' SquadId=\'72\' Squad=\'72\'/>
	<z:row MatchId=\'1\' SquadId=\'73\' Squad=\'73\'/>
	<z:row MatchId=\'1\' SquadId=\'74\' Squad=\'74\'/>
	<z:row MatchId=\'1\' SquadId=\'75\' Squad=\'75\'/>
	<z:row MatchId=\'1\' SquadId=\'76\' Squad=\'76\'/>
	<z:row MatchId=\'1\' SquadId=\'77\' Squad=\'77\'/>
	<z:row MatchId=\'1\' SquadId=\'78\' Squad=\'78\'/>
	<z:row MatchId=\'1\' SquadId=\'79\' Squad=\'79\'/>
	<z:row MatchId=\'1\' SquadId=\'80\' Squad=\'80\'/>
	<z:row MatchId=\'1\' SquadId=\'81\' Squad=\'81\'/>
	<z:row MatchId=\'1\' SquadId=\'82\' Squad=\'82\'/>
	<z:row MatchId=\'1\' SquadId=\'83\' Squad=\'83\'/>
	<z:row MatchId=\'1\' SquadId=\'84\' Squad=\'84\'/>
	<z:row MatchId=\'1\' SquadId=\'85\' Squad=\'85\'/>
	<z:row MatchId=\'1\' SquadId=\'86\' Squad=\'86\'/>
	<z:row MatchId=\'1\' SquadId=\'87\' Squad=\'87\'/>
	<z:row MatchId=\'1\' SquadId=\'88\' Squad=\'88\'/>
	<z:row MatchId=\'1\' SquadId=\'89\' Squad=\'89\'/>
	<z:row MatchId=\'1\' SquadId=\'90\' Squad=\'90\'/>
	<z:row MatchId=\'1\' SquadId=\'91\' Squad=\'91\'/>
	<z:row MatchId=\'1\' SquadId=\'92\' Squad=\'92\'/>
	<z:row MatchId=\'1\' SquadId=\'93\' Squad=\'93\'/>
	<z:row MatchId=\'1\' SquadId=\'94\' Squad=\'94\'/>
	<z:row MatchId=\'1\' SquadId=\'95\' Squad=\'95\'/>
	<z:row MatchId=\'1\' SquadId=\'96\' Squad=\'96\'/>
	<z:row MatchId=\'1\' SquadId=\'97\' Squad=\'97\'/>
	<z:row MatchId=\'1\' SquadId=\'98\' Squad=\'98\'/>
	<z:row MatchId=\'1\' SquadId=\'99\' Squad=\'99\'/>
	<z:row MatchId=\'1\' SquadId=\'100\' Squad=\'100\'/>
	<z:row MatchId=\'1\' SquadId=\'101\' Squad=\'101\'/>
	<z:row MatchId=\'1\' SquadId=\'102\' Squad=\'102\'/>
	<z:row MatchId=\'1\' SquadId=\'103\' Squad=\'103\'/>
	<z:row MatchId=\'1\' SquadId=\'104\' Squad=\'104\'/>
	<z:row MatchId=\'1\' SquadId=\'105\' Squad=\'105\'/>
	<z:row MatchId=\'1\' SquadId=\'106\' Squad=\'106\'/>
	<z:row MatchId=\'1\' SquadId=\'107\' Squad=\'107\'/>
	<z:row MatchId=\'1\' SquadId=\'108\' Squad=\'108\'/>
	<z:row MatchId=\'1\' SquadId=\'109\' Squad=\'109\'/>
	<z:row MatchId=\'1\' SquadId=\'110\' Squad=\'110\'/>
	<z:row MatchId=\'1\' SquadId=\'111\' Squad=\'111\'/>
	<z:row MatchId=\'1\' SquadId=\'112\' Squad=\'112\'/>
	<z:row MatchId=\'1\' SquadId=\'113\' Squad=\'113\'/>
	<z:row MatchId=\'1\' SquadId=\'114\' Squad=\'114\'/>
	<z:row MatchId=\'1\' SquadId=\'115\' Squad=\'115\'/>
	<z:row MatchId=\'1\' SquadId=\'116\' Squad=\'116\'/>
	<z:row MatchId=\'1\' SquadId=\'117\' Squad=\'117\'/>
	<z:row MatchId=\'1\' SquadId=\'118\' Squad=\'118\'/>
	<z:row MatchId=\'1\' SquadId=\'119\' Squad=\'119\'/>
	<z:row MatchId=\'1\' SquadId=\'120\' Squad=\'120\'/>
	<z:row MatchId=\'1\' SquadId=\'121\' Squad=\'121\'/>
	<z:row MatchId=\'1\' SquadId=\'122\' Squad=\'122\'/>
	<z:row MatchId=\'1\' SquadId=\'123\' Squad=\'123\'/>
	<z:row MatchId=\'1\' SquadId=\'124\' Squad=\'124\'/>
	<z:row MatchId=\'1\' SquadId=\'125\' Squad=\'125\'/>
	<z:row MatchId=\'1\' SquadId=\'126\' Squad=\'126\'/>
	<z:row MatchId=\'1\' SquadId=\'127\' Squad=\'127\'/>
	<z:row MatchId=\'1\' SquadId=\'128\' Squad=\'128\'/>
	<z:row MatchId=\'1\' SquadId=\'129\' Squad=\'129\'/>
	<z:row MatchId=\'1\' SquadId=\'130\' Squad=\'130\'/>
	<z:row MatchId=\'1\' SquadId=\'131\' Squad=\'131\'/>
	<z:row MatchId=\'1\' SquadId=\'132\' Squad=\'132\'/>
	<z:row MatchId=\'1\' SquadId=\'133\' Squad=\'133\'/>
	<z:row MatchId=\'1\' SquadId=\'134\' Squad=\'134\'/>
	<z:row MatchId=\'1\' SquadId=\'135\' Squad=\'135\'/>
	<z:row MatchId=\'1\' SquadId=\'136\' Squad=\'136\'/>
	<z:row MatchId=\'1\' SquadId=\'137\' Squad=\'137\'/>
	<z:row MatchId=\'1\' SquadId=\'138\' Squad=\'138\'/>
	<z:row MatchId=\'1\' SquadId=\'139\' Squad=\'139\'/>
	<z:row MatchId=\'1\' SquadId=\'140\' Squad=\'140\'/>
	<z:row MatchId=\'1\' SquadId=\'141\' Squad=\'141\'/>
	<z:row MatchId=\'1\' SquadId=\'142\' Squad=\'142\'/>
	<z:row MatchId=\'1\' SquadId=\'143\' Squad=\'143\'/>
	<z:row MatchId=\'1\' SquadId=\'144\' Squad=\'144\'/>
	<z:row MatchId=\'1\' SquadId=\'145\' Squad=\'145\'/>
	<z:row MatchId=\'1\' SquadId=\'146\' Squad=\'146\'/>
	<z:row MatchId=\'1\' SquadId=\'147\' Squad=\'147\'/>
	<z:row MatchId=\'1\' SquadId=\'148\' Squad=\'148\'/>
	<z:row MatchId=\'1\' SquadId=\'149\' Squad=\'149\'/>
	<z:row MatchId=\'1\' SquadId=\'150\' Squad=\'150\'/>
	<z:row MatchId=\'1\' SquadId=\'151\' Squad=\'151\'/>
	<z:row MatchId=\'1\' SquadId=\'152\' Squad=\'152\'/>
	<z:row MatchId=\'1\' SquadId=\'153\' Squad=\'153\'/>
	<z:row MatchId=\'1\' SquadId=\'154\' Squad=\'154\'/>
	<z:row MatchId=\'1\' SquadId=\'155\' Squad=\'155\'/>
	<z:row MatchId=\'1\' SquadId=\'156\' Squad=\'156\'/>
	<z:row MatchId=\'1\' SquadId=\'157\' Squad=\'157\'/>
	<z:row MatchId=\'1\' SquadId=\'158\' Squad=\'158\'/>
	<z:row MatchId=\'1\' SquadId=\'159\' Squad=\'159\'/>
	<z:row MatchId=\'1\' SquadId=\'160\' Squad=\'160\'/>
	<z:row MatchId=\'1\' SquadId=\'161\' Squad=\'161\'/>
	<z:row MatchId=\'1\' SquadId=\'162\' Squad=\'162\'/>
	<z:row MatchId=\'1\' SquadId=\'163\' Squad=\'163\'/>
	<z:row MatchId=\'1\' SquadId=\'164\' Squad=\'164\'/>
	<z:row MatchId=\'1\' SquadId=\'165\' Squad=\'165\'/>
	<z:row MatchId=\'1\' SquadId=\'166\' Squad=\'166\'/>
	<z:row MatchId=\'1\' SquadId=\'167\' Squad=\'167\'/>
	<z:row MatchId=\'1\' SquadId=\'168\' Squad=\'168\'/>
	<z:row MatchId=\'1\' SquadId=\'169\' Squad=\'169\'/>
	<z:row MatchId=\'1\' SquadId=\'170\' Squad=\'170\'/>
	<z:row MatchId=\'1\' SquadId=\'171\' Squad=\'171\'/>
	<z:row MatchId=\'1\' SquadId=\'172\' Squad=\'172\'/>
	<z:row MatchId=\'1\' SquadId=\'173\' Squad=\'173\'/>
	<z:row MatchId=\'1\' SquadId=\'174\' Squad=\'174\'/>
	<z:row MatchId=\'1\' SquadId=\'175\' Squad=\'175\'/>
	<z:row MatchId=\'1\' SquadId=\'176\' Squad=\'176\'/>
	<z:row MatchId=\'1\' SquadId=\'177\' Squad=\'177\'/>
	<z:row MatchId=\'1\' SquadId=\'178\' Squad=\'178\'/>
	<z:row MatchId=\'1\' SquadId=\'179\' Squad=\'179\'/>
	<z:row MatchId=\'1\' SquadId=\'180\' Squad=\'180\'/>
	<z:row MatchId=\'1\' SquadId=\'181\' Squad=\'181\'/>
	<z:row MatchId=\'1\' SquadId=\'182\' Squad=\'182\'/>
	<z:row MatchId=\'1\' SquadId=\'183\' Squad=\'183\'/>
	<z:row MatchId=\'1\' SquadId=\'184\' Squad=\'184\'/>
	<z:row MatchId=\'1\' SquadId=\'185\' Squad=\'185\'/>
	<z:row MatchId=\'1\' SquadId=\'186\' Squad=\'186\'/>
	<z:row MatchId=\'1\' SquadId=\'187\' Squad=\'187\'/>
	<z:row MatchId=\'1\' SquadId=\'188\' Squad=\'188\'/>
	<z:row MatchId=\'1\' SquadId=\'189\' Squad=\'189\'/>
	<z:row MatchId=\'1\' SquadId=\'190\' Squad=\'190\'/>
	<z:row MatchId=\'1\' SquadId=\'191\' Squad=\'191\'/>
	<z:row MatchId=\'1\' SquadId=\'192\' Squad=\'192\'/>
	<z:row MatchId=\'1\' SquadId=\'193\' Squad=\'193\'/>
	<z:row MatchId=\'1\' SquadId=\'194\' Squad=\'194\'/>
	<z:row MatchId=\'1\' SquadId=\'195\' Squad=\'195\'/>
	<z:row MatchId=\'1\' SquadId=\'196\' Squad=\'196\'/>
	<z:row MatchId=\'1\' SquadId=\'197\' Squad=\'197\'/>
	<z:row MatchId=\'1\' SquadId=\'198\' Squad=\'198\'/>
	<z:row MatchId=\'1\' SquadId=\'199\' Squad=\'199\'/>
	<z:row MatchId=\'1\' SquadId=\'200\' Squad=\'200\'/>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/STAGE.XML');
  $fh = fopen('./xml/STAGE.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StageId\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'StageId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StageName\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'StageName\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'32\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Location\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'Location\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'32\'/>
		</s:AttributeType>
		<s:AttributeType name=\'FirearmId\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TypeFirearmId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CourseId\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TypeStageCourseId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ScoringId\' rs:number=\'7\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TypeScoringId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtTypeId\' rs:number=\'8\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TypeTargetClassifyId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'IcsStageId\' rs:number=\'9\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TypeStdStageSetupId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Remove\' rs:number=\'10\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStage\'
			 rs:basecolumn=\'RemoveScoring\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtPaper\' rs:number=\'11\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TrgtPaper\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtPopper\' rs:number=\'12\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TrgtPopper\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtPlates\' rs:number=\'13\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TrgtPlates\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtVanish\' rs:number=\'14\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TrgtDisappear\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TrgtPenlty\' rs:number=\'15\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'TrgtPenalty\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MinRounds\' rs:number=\'16\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'MinRounds\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ReportOn\' rs:number=\'17\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchStage\'
			 rs:basecolumn=\'ReportOn\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MaxPoints\' rs:number=\'18\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'MaxPoints\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StartPos\' rs:number=\'19\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'StartPosition\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'536870910\' rs:long=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StartOn\' rs:number=\'20\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'StartOn\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'8\'/>
		</s:AttributeType>
		<s:AttributeType name=\'StringCnt\' rs:number=\'21\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'StringsOfFire\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Descriptn\' rs:number=\'22\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchStage\' rs:basecolumn=\'Description\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'536870910\' rs:long=\'true\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/TEAM.XML');
  $fh = fopen('./xml/TEAM.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatchTeam\' rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'TeamId\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchTeam\'
			 rs:basecolumn=\'TeamId\' rs:keycolumn=\'true\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'DivId\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchTeam\'
			 rs:basecolumn=\'TypeDivisionId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CatId\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchTeam\'
			 rs:basecolumn=\'TypeNonTeamCategoryId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Team\' rs:number=\'5\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatchTeam\'
			 rs:basecolumn=\'Team\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'32\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

  unlink('./xml/THEMATCH.XML');
  $fh = fopen('./xml/THEMATCH.XML', 'w');
  $xmlData='<xml xmlns:s=\'uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882\'
	xmlns:dt=\'uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\'
	xmlns:rs=\'urn:schemas-microsoft-com:rowset\'
	xmlns:z=\'#RowsetSchema\'>
<s:Schema id=\'RowsetSchema\'>
	<s:ElementType name=\'row\' content=\'eltOnly\' rs:updatable=\'true\'>
		<s:AttributeType name=\'MatchId\' rs:number=\'1\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'MatchId\' rs:keycolumn=\'true\' rs:autoincrement=\'true\'>
			<s:datatype dt:type=\'int\' dt:maxLength=\'4\' rs:precision=\'10\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MatchName\' rs:number=\'2\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'MatchName\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'50\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MatchDt\' rs:number=\'3\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'MatchDt\'>
			<s:datatype dt:type=\'dateTime\' rs:dbtype=\'variantdate\' dt:maxLength=\'16\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'ClubId\' rs:number=\'4\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'ClubId\'>
			<s:datatype dt:type=\'i2\' dt:maxLength=\'2\' rs:precision=\'5\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'Chrono\' rs:number=\'5\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'Chronograph\'>
			<s:datatype dt:type=\'boolean\' dt:maxLength=\'2\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MatchLevel\' rs:number=\'6\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'TypeMatchLevel\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'CountryId\' rs:number=\'7\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'TypeCountryId\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'3\'/>
		</s:AttributeType>
		<s:AttributeType name=\'FirearmId\' rs:number=\'8\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'TypeFirearmId\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'SquadCount\' rs:number=\'9\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\'
			 rs:basetable=\'tblMatch\' rs:basecolumn=\'SquadCount\'>
			<s:datatype dt:type=\'ui1\' dt:maxLength=\'1\' rs:precision=\'3\' rs:fixedlength=\'true\'/>
		</s:AttributeType>
		<s:AttributeType name=\'MD\' rs:number=\'10\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'MatchDirector\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'RM\' rs:number=\'11\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'RangeMaster\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:AttributeType name=\'SD\' rs:number=\'12\' rs:nullable=\'true\' rs:maydefer=\'true\' rs:writeunknown=\'true\' rs:basetable=\'tblMatch\'
			 rs:basecolumn=\'StatsDirector\'>
			<s:datatype dt:type=\'string\' dt:maxLength=\'40\'/>
		</s:AttributeType>
		<s:extends type=\'rs:rowbase\'/>
	</s:ElementType>
</s:Schema>
<rs:data>
;;;	<z:row MatchId=\'1\' MatchName=\'Eggenberg CUP 2021 - X. kolo\' MatchDt=\'1970-015-01T09:00:00\' ClubId=\'1\' Chrono=\'False\'
		 MatchLevel=\'1\' CountryId=\'CZE\' FirearmId=\'1\' SquadCount=\'8\' MD=\'Antonín Liška\' RM=\'Ondřej Bárta\'
		 SD=\'Milan Žídek, Ladislav Novák\'/>
</rs:data>
</xml>';
  fwrite($fh, $xmlData);
  fclose($fh);

$zip = new ZipArchive();
$filename = "./xml/WinMSS.ZIP";
unlink($filename);
if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    echo "cannot open <$filename>";
} else {  
  $zip->addFile("./xml/CLASSIFY.XML","CLASSIFY.XML");
  $zip->addFile("./xml/CLUB.XML","CLUB.XML");
  $zip->addFile("./xml/ENROLLED.XML","ENROLLED.XML");
  $zip->addFile("./xml/MEMBER.XML","MEMBER.XML");
  $zip->addFile("./xml/SCORE.XML","SCORE.XML");
  $zip->addFile("./xml/SQUAD.XML","SQUAD.XML");
  $zip->addFile("./xml/STAGE.XML","STAGE.XML");
  $zip->addFile("./xml/TAG.XML","TAG.XML");
  $zip->addFile("./xml/TEAM.XML","TEAM.XML");
  $zip->addFile("./xml/THEMATCH.XML","THEMATCH.XML");
  //echo "numfiles: " . $zip->numFiles . "\n";
  //echo "status:" . $zip->status . "\n";
  $zip->close();
}
}
?>