<?php

$obj = new UAEday($spell_checked, $req);
var_dump($obj->return);

if (!empty($obj->return["result"])) {
    $total_return = $obj->return["result"];
    if (!empty($obj->return["options"])) {
        $options_list = array_merge($options_list, $obj->return["options"]);
        $list = array_merge($list, $obj->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'uaeday';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}


class UAEday {

    public $return = array();

    function __construct($spell_checked, $req) {
        if ($spell_checked == "uae day") {
            $this->return["result"] = "The United Arab Emirates is a federation of seven emirates; Abu Dhabi, Dubai, Sharjah, Ras Al Khaimah, Ajman, Umm Al Quwain and Fujairah.
Capital: Abu Dhabi
Total Area: 83600 km² (including islands)
Location: Between latitudes 22 and 26.5 north and longitude 51 and 56.51 east. The UAE is bordered by the Arabia Gulf in the north, Oman and the Gulf of in the East, Oman and Saudi Arabia in the south and Qatar and Saudi Arabia in the west.
Climate: UAE is warm and sunny in winter and hot and humid during the summer months. Winter daytime temperatures average a very pleasant 26°C, although nights can be relatively cool, between 12–15°C. Summer temperatures are in the mid-40s, but can be higher inland.
National Day: 2 December 1971
Religion:Islam
Official Language:Arabic
Time: GMT + 4
Currency: Dirham ($1=AED 3.672)
Population:8,200,000 (2009 estimates)";

            $this->return["options"][] = "uae history";
            $this->return["list"][] = array("content" => "__uae__history__");

            $this->return["options"][] = "culture and heritage";
            $this->return["list"][] = array("content" => "__uae__heritage__");

            $this->return["options"][] = "uae economy";
            $this->return["list"][] = array("content" => "__uae__economy__");

            $this->return["options"][] = "uae flag story";
            $this->return["list"][] = array("content" => "__uae__flag__");
        } elseif ($req == "__uae__history__") {

            $this->return["result"] = "History of the Country and Establishment of the Union
Archeological excavations and antiques found in many areas of the country have proved that a great civilization used to be prosperous in the area known today as the United Arab Emirates. The civilization dates back to 4000 BC, and was connected to the neighboring civilizations. Pieces of colored pottery that have been uncovered were imported from Mesopotamia. They date back to 3000 BC, which indicate the links between these areas and the people of South Iraq.
Various stone tools, sharp sword blades and metal sheets were found. Excavations show forts at Hilly site, Bidya, Tell Abraq and Kalbaa that date back 2500-2000 B.C. Recent discoveries show a square citadel with square towers at its corners, in addition to an external wall of 55m long, and a stone mould to make metal coins inside the citadel.
With the coming of Islam, a new phase of the country's history had begun, as Islam reached this country thanks to the Arab leader Amr bin Al-As. The Gulf area under the rule of Islam witnessed a prosperous period, and the Gulf became an international hub of marine trade and navigation during the Umayyad age when the vessel industry prospered.
An archeological site at Jumeirah area in Dubai has been identified as the remainder of an Islamic city of the Umayyad age, which was controlling the trade routes at that time. One of the known Islamic cities is Julphar north of the city of Ras Al Khaimah, where houses were found and four mosques dating back to the Hijri fourth century. 
H. H. Sheikh Zayed bin Sultan Al Nahyan, Founder of the Union 
H. H. Sheikh Zayed bin Sultan Al Nahyan (may Allah bless his Soul), was born in 1918. In 1946, he was elected ruler of Al Ain and in 1966, he became ruler of Abu Dhabi. In 1968, Britain announced that it would withdraw from the area. Immediately Sheikh Zayed took the lead in calling for a federation of the emirates. The rulers of the emirates moved quickly and on the 2nd December, 1971, the United Arab Emirates formally emerged onto the international stage.
On November 2, 2004, Sheikh Zayed passed away, after a long journey of giving and achievements. In line with his vision, the nation keeps going under the leadership of? H. H. Sheikh Khalifa bin Zayed Al Nahyan, President of United Arab Emirates and the members of the Supreme Council of Rulers and their Crown Princes.";

            $this->return["options"][] = "main menu";
            $this->return["list"][] = array("content" => "uae day");
            
        } elseif ($req == "__uae__heritage__") {

            $this->return["result"] = "The United Arab Emirates has a rich history dating back to thousands of years. So, the country is concerned with preserving and documenting such heritage for the next generations.
President H. H. Sheikh Khalifa bin Zayed Al Nahyan and the members of Supreme Council are keen on preserving and promoting the UAE heritage amongst the youth by educating them; thus, linking the glorious past and the magnificent civilisation with its future generation.
Therefore, His Highness Sheikh Khalifa bin Zayed Al Nahyan, the President, has urged the cultural, educational and academic institutions to keep the good work to raise awareness in the youth of their cultural and civilized heritage of their country.
H. H. Sheikh Zayed bin Sultan Al Nahyan, the late president and founding father of the United Arab Emirates, had a great interest in preserving the heritage for the benefit of the country and the next generations. His interest was not limited to the national heritage, but included international heritage, as he established a USD 150,000 award with UNESCO to encourage human creativity and save threatened heritage monuments.
There are many authorities concerned with preserving the heritage in the country such as: Emirates Heritage Club, Emirates Diving Society, Traditional Heritage Renewal Society, Research and Documents Center and others. Throughout the county, there are museums and heritage villages of the past ages.
The National Council of Tourism & Antiquities offers a lot of information about the UAE";

            $this->return["options"][] = "main menu";
            $this->return["list"][] = array("content" => "uae day");
        } elseif ($req == "__uae__economy__") {

            $this->return["result"] = "According to the UAE Economic Report 2012, the country's Gross Domestic Product (GDP) (at constant prices) reached around AED 981 Billion in 2011 at a growth rate of 4.2 per cent compared to AED 942 Billion in 2010 at a growth rate of 1.3 per cent.
Oil prices remained high (the average price per barrel was 107 US Dollars in 2011), which boosted government revenues thus stimulating investment and boosting the development of the other economic sectors; such as, alternative and renewable energy and the peaceful nuclear energy for maintaining non-renewable oil resources.
The UAE has also established its position as a major centre for trade, tourism and investment, where the trade balance achieved a surplus of 291.9 billion AED in 2011 representing 23.5 per cent of the GDP.
The UAE enjoys a strong economy supported by an ideal investment climate with effective economic and investment policies, based on legal and institutional structures in line with global standards, which created a positive impact on the foreign investment flows to the UAE and supported its economic orientations.";

            $this->return["options"][] = "main menu";
            $this->return["list"][] = array("content" => "uae day");
        } elseif ($req == "__uae__flag__") {

            $this->return["result"] = "UAE flag was adopted on the 2nd of December 1971 and hoisted by the late Sheikh Zayed Bin Sultan Al Nahyan , may God rest his soul in peace, declaring the establishment of the United Arab Emirates as an independent country.
The UAE flag consists of four colours; green, white, black, and red. All four of which stand for Arabian unity. The flag, the length of which is twice the width, was designed In 1971 by a young Emirati, Abdullah Mohammed Al Maainah. Afterwards, Al Maainah, the flag designer, held the post of plenipotentiary minister at the UAE Foreign Ministry
The Flag was designed by Mr. Abdulla Mohammed Al Ma’enah after he read an advertisement announcing competition for designing the UAE flag. About 1030 designs participated and only 6 were short-listed and finally the present flag.
The flag displays three equal horizontal bands of green, white and black respectively from the top downwards, while the vertical strip of red is next to the mast. Al Maainah intended the four colours to reflect Arabian unity, the theme of which appears In the two stanzas of an Arabic poem by Safiul Din Al Holi who described deeds of benevolence, goodness and kindness. The poet wrote about the hard-fought historical battles of the land, with deeds and intentions that were white, meaning benign, but the vigour of the battles were black, meaning strong, while the lands were vast and green, and the gallant swords were stained with red blood.";

            $this->return["options"][] = "main menu";
            $this->return["list"][] = array("content" => "uae day");
        }
    }

}


?>
