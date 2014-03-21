<?php

global $spell_checked;
if ($recipe_status) {
    $recipe = str_replace($check_recipe, "", $spell_checked);
}

$rest_return_value = array();
$return_value = "";
$return_title = "";
$tags = array('banana', 'cherry', 'sauce', 'pudding', 'thore-a', 'sindhi', 'speciality', 'mohan', 'thal', 'gujhia', 'coconut', 'barfi', 'balushahi', 'chiku', 'malpua', 'seviyan', 'kheer', 'gajar', 'halva', 'choco', 'balls', 'mixed', 'fruit', 'cream', 'tomato', 'rice', 'soup', 'thandai', 'vada', 'kanji', 'phirni', 'christmas', 'bar', 'frozen', 'chocolate', 'cake', 'orange', 'ice', 'salad', 'teel', 'poli', 'maharashtra', 'til', 'gajak', 'punjab', 'sweet', 'pongal', 'tamil', 'nadu', 'lemon', 'served', 'during', 'ponga', 'corn', 'fingers', 'grilled', 'jacket', 'potatoes', 'chinese', 'stick', 'double', 'decker', 'sandwich', 'mayonnaise', 'spinach', 'kootu', 'pulav', 'sambaaro', 'podi', 'idli', 'podi', 'bread', 'halwa', 'spanish', 'roast', 'chicken', 'baked', 'beans', 'augratin', 'green', 'curry', 'ice-cream', 'paan', 'kaju', 'kopra', 'sheera', 'besan', 'laddu', 'kesar', 'malai', 'kulfi', 'layered', 'chapaties', 'sour', 'hot', 'vegetable', 'roti', 'sesame', 'hare', 'mattar', 'puri', 'rolls', 'three-in-one', 'manchurian', 'moghlai', 'aloo', 'hakka', 'noodles', 'tava', 'mushroom', 'kadai', 'paneer', 'chana', 'white', 'gravy', 'chat-pata', 'pav', 'peas', 'pullav', 'tikka', 'pullao', 'mint', 'raita', 'korma', 'celery', 'cucumber', 'grape', 'date', 'wontons', 'imperial', 'honeyed', 'vanilla', 'ice-cr', 'vegetables', 'toffee', 'apples', 'french', 'onion', 'pancakes', 'creamy', 'mushrooms', 'cauliflower', 'schezuan', 'chowder', 'bean', 'sprouts', 'strawberries', 'grand', 'marnier', 'hawaiian', 'pineapple', 'upside', 'down', 'mango', 'nut', 'slices', 'chinese', 'style', 'potato', 'papaya', 'pan', 'fried', 'noodle', 'sala', 'long', 'stuffed', 'buns', 'relish', 'kadhi', 'caribbean', 'crepes', 'dip', 'miami', 'cup', 'drunken', 'grapes', 'mexican', 'salsa', 'curry', 'tofu', 'vegetabl', 'burgers', 'picante', 'spicy', 'salsa', 'kacchi', 'keri', 'ni', 'chutney', 'ginger', 'chips', 'moong', 'dal', 'kathol', 'thai', 'delight', 'bhakhri', 'tacos', 'rotla', 'macroni', 'pot', 'theplas', 'crispy', 'handi', 'chatuchak', 'enchiladas', 'chiki', 'triangles', 'cheese', 'walnut', 'apple', 'fig', 'pizza', 'baby', 'tarts', 'herb', 'burrito', 'fajitas', 'food', 'bonanza', 'macaroni', 'supreme', 'italian', 'coffee', 'mousse', 'spaghetti', 'shell', 'pasta', 'sa', 'almond', 'pizzas', 'italiano', 'puffed', 'sweety', 'minutes', 'corny', 'canneloni', 'milanaise', 'chilli', 'villi', 'bean-potato', 'fettucine', 'khaman', 'dhokla', 'sojjapam', 'ratatouille', 'lasagne', 'samosa', 'poor', 'ravioli', 'khasta', 'namkin', 'cott', 'rasmalai', 'mini', 'tiramisu', 'spicy', 'cabbage', 'eggs', 'kari', 'methi', 'muthia', 'bitter', 'gourd', 'fry', 'onions', 'rasam', 'pulusenions', 'baigan', 'bharta', 'vermicille', 'fresh', 'garlic', 'toamato', 'spicy', 'parathas', 'lifafa', 'pulao', 'badam', 'urad', 'dosa', 'quick', 'kofta', 'biryani', 'coriander', 'kathi', 'roll', 'chila', 'fudge', 'sundae', 'chocolate', 'ekpani', 'florida', 'basic', 'cochin', 'masala', 'curries', 'yam', 'cocoa', 'cake', 'eggless', 'tuvar', 'sambhar', 'fondue', 'drumstick', 'chitranna', 'bisibele', 'bhaat', 'puliyam', 'sadam', 'tarmarind', 'rice', 'potage', 'darblay', 'curd', 'soft', 'fluffy', 'idlis', 'rava', 'dainty', 'jeera', 'dinner', 'kancheepuram', 'eggplant', 'sada', 'minestrone', 'neer', 'medu', 'wada', 'payasam', 'ragda', 'patties', 'rasayam', 'kachori', 'capsicum', 'gol', 'papdi', 'veg', 'dapka', 'kheema', 'mughlai', 'paranth', 'vatana', 'nu', 'oondhiyu', 'trio', 'cones', 'brownies', 'mein', 'chow', 'macaroons', 'stewed', 'muffins', 'spring', 'florentine', 'biscuits', 'caramel', 'munshu', 'pinwheel', 'circles', 'marshmallow', 'american', 'chop', 'suey', 'truffles', 'clear', 'gazpacho', 'souffle', 'kidney', 'rajma', 'tortilla', 'barrito', 'cottage', 'bhath', 'okra', 'thokku', 'bagara', 'burfi', 'fish', 'tart', 'herbal', 'easy', 'cheesy', 'toast', 's', 'spagetti', 'original', 'margherita', 'skillet', 'asparagus', 'c', 'basil', 'fusilli', 'chiken', 'carrot', 'sandwiches', 'russian', 'low', 'cal', 'open', 'snack', 'tum', 'yum', 'gold', 'coin', '�', 'broccoli', 'szechwan', 'platter', 'egg-fried', 'ensalada', 'de', 'ejotes', 'green', 'kebabs', 'papas', 'con', 'queso', 'pepper', 'eggless', 'uttapa', 'shahi', 'puris', 'pyaaz', 'masaledar', 'parathe', 'khichadi', 'pearl', 'chane', 'ke', 'kabab', 'healthy', 'chat-pati', 'frankies', 'croquettes', 'crackers', 'puffs', 'au', 'gratin', 'chola', 'muthias', 'lapsi', 'basundi', 'doodh', 'paak', 'vaal', 'no', 'raiwala', 'marcha', 'fruity', 'jelly', 'cups', 'pina', 'colada', 'doughnuts', 'devil', 'pie', 'whole', 'wheat', 'roasted', 'brown', 'gnocchi', 'mozzarella', 'sticks', 'olive', 'crostini', 'peach', 'lettuce', 'moyettes', 'muscovado', 'sugar', 'syru', 'kadhai', 'hot', 'khoya', 'bombay', 'bhaji', 'egg', 'peanut', 'ladies', 'finger', 'kulambu', 'sitafal', 'firni', 'instant', 'jalebis', 'papad', 'chole', 'kababs', 'makhani', 'pani', 'bhel', 'bal', 'avocado', 'rellenos', 'capsicums', 'milanese', 'sun-dried', 'riso', 'three', 'bell', 'tartlets', 'canapes', 'gateau', 'strawberry', 'yogurt', 'plant', 'channadal', 'channa', 'dahi', 'ghosh', 'pal', 'gova', 'moar', 'kali', 'leaves', 'thugayal', 'pottu', 'kadalai', 'inji', 'ginger', 'hard', 'tri', 'colour', 'kara', 'adai', "65", 'thattai', 'pakoras', 'broiled', 'grapefruit', 'guacamole', 'red', 'chillies', 'besani', 'bhindi', 'iyengari', 'thanda', 'pakodas', 'da', 'ghobhi', 'wale', 'kofte', 'mutter', 'noorani', 'cocktail', 'pakori', 'anjeer', 'hyderabadi', 'bhutt', 'kurma', 'custard', 'pais', 'anokha', 'rabdi', 'sang', 'boondi', 'haka', 'maryland', 'crab', 'palak', 'pudina', 'tangy', 'namkeen', 'lassi', 'khus', 'lime', 'soda', 'missi', 'kashmiri', 'makkai', 'doodhi', 'amritsari', 'dum', 'majedaar', 'baingan', 'monger', 'ghugra', 'adadiya', 'sukhi', 'shimla', 'mirch', 'subzi', 'cucumbers', 'dill', 'kasuri', 'hara', 'kebab', 'mooli', 'lababdar', 'lakhnavi', 'khumb', 'preserves', 'salan', 'avail', 'mughalai', 'navratan', 'katli', 'colonial', 'virginia', 'ash', 'cakes', 'hush', 'puppies', 'somasi', 'oothappam', 'pista', 'burrfi', 'aam', 'peda', 'dudhi', 'bartha', 'chatni', 'achari', 'meetha', 'pakoda', 'tikki', 'jatphat', 'makhanwala', 'tamatar', 'bertha', 'soya', 'hariyali', 'aonkha', 'adraki', 'bheerbal', 'jaalfrazie', 'capsicum', 'tomatoes', 'chops', 'maharani', 'moghal', 'khichidi', 'chuntney', 'kajur', 'imli', 'mitha', 'achar', 'shorba', 'simmi', 'cutlets', 'blender', 'caesar', 'dressing', 'flake', 'lorenzo', 'gourd', 'ambrosia', 'purees.', 'mutton', 'frysouth', 'indian', 'style', 'cuttney', 'dry', 'mukari', 'vermicelli', 'ladoo', 'stuffed', 'idlis', 'extra', 'puffy', 'milagu', 'pepper', 'kuzambu', 'mix', 'flour', 'uttappa', 'jaisalmeri', 'chatpata', 'channa', 'dal', 'dhokla', 'burger', 'icing', 'kachumber', 'yoghurt', 'salad', 'pak', 'poha', 'farcha', 'betty', 'potatoes', 'mathias', 'payasam', '+', 'sabudaana', 'bharva', 'bhaigan', 'idli', 'vathakuzhambu', 'maida', 'podimas', 'tuna', 'gosht', 'frittata', 'raw', 'cutlet', 'omlet', 'bittergourd', 'chutney', 'nachni', 'therattipal', 'raddish', 'thoran', 'cucumber', 'aromised', 'parotha', 'fruit', 'nut', 'rice', 'srilankan', 'saffron', 'corn', 'toast', 'creme', 'anglais', 'muesli', 'bahar', 'bittergourd', 'curd', 'rolly', 'polly', 'jhatpat', 'sooji', 'burfu', 'spicy', 'tomato', 'soup', 'chettinad', 'indo-chinese', 'brinjal', 'masaledar', 'punjabi', 'paneer', 'wine', 'saag', 'upma', 'butter', 'brownie', 'tiranga', 'fish', 'cutlet', 'golden', 'mushrooms', 'prawns', 'sukka', 'biriyani', 'nasi', 'lemakmalay', 'vaagi', 'baath', 'pumpkin', 'suji', 'yummy', 'simple', 'fish', 'powder', 'palli', 'pakodaspicy', 'peanuts', 'crispy', 'green', 'peas', 'pudina', 'rasam', 'cauliflower', 'aloo', 'kurma', 'tomato-mint', 'rice', 'channa', 'masala', 'greendhal', 'sasam', 'plain', 'rasgulla', 'multi-coloured', 'paratha', 'cucumberdosakaya', 'perugu', 'pacc', 'bottlegourd', 'peel', 'potatao-papad', 'boondi', 'raita', 'puries', 'chuduvafried', 'poha', 'brinjal', 'dhal', 'kootu', 'uthapam', 'poriyal', 'keerai', 'crunchy', 'fillets', 'chive', 'may', 'rava', 'besan', 'rice', 'gurvani', 'kesari', 'kalakand', 'gujarati', 'kadi', 'fried', 'dessert', 'very', 'easy', 'banana', 'nut', 'bread', 'idly', 'khandvi', 'mohanthaal', 'shrikhand', 'orignal', 'kothmari', 'ni', 'chaatni', 'theplaas', 'panner_coconut', 'cutlets', 'gobi', 'beetroot', 'paratha', 'delite', 'year', 'old', 'baby', 'paste', 'lemak', 'egg', 'baji', 'fatafat', 'ghoday', 'laddoo', 'chat', 'idli', 'chunks', 'bhajia', 'matar', 'au', 'daal', 'chilla', 'kadi', 'moru', 'kolambu', 'majig', 'virgin', 'mary', 'mocktail', 'bhara', 'pachadi', 'hawaiian', 'chicken', 'salad', 'cholclate', 'kentucky', 'hagalkai', 'bittergourd', 'kossamb', 'bhaajee', 'cocnu', 'milk', 'potato-', 'gra', 'potato-capsicum', 'gravy', 'leftover', 'koftas', 'semiya', 'duo', 'roshagullas', 'milk', 'chuttney', 'snacks', 'mushroom', 'tadka', 'indian', 'tacos', 'veg', 'shrimp', 'thokku', 'potato', 'puri', 'suji', 'pancakes', 'maangai', 'sodhi', 'kuzhambuavial', 'kuzhambu', 'indian', 'macaronies', 'alu', 'haldi', 'basmati', 'tender', 'mango', 'unniyapam', 'aval', 'uppumarice', 'flake', 'uppuma', 'matar', 'ke', 'kheer', 'beetroot', 'vangibath', 'sabudana', 'vada', 'amla', 'pickle', 'ladyfingers', 'vadas', 'veggie', 'chaat', 'mash', 'melon', 'shake', 'groundnut', 'sprouts', 'bhendi', 'cabbage', 'puffed', 'upma', 'spagatiee', 'meat', 'balls', 'goan', 'prawn', 'lemon', 'chicken', 'low', 'fat', 'aussie', 'healthy', 'rainbow', 'paratha', 'surali', 'role', 'way', 'delight', 'halwa', 'split', 'chick', 'moganti', 'vadas', 'flower', 'curry', 'ariti', 'poo', 'curryariti', 'poov', 'vegetarian', 'quesadillas', 'ambal', 'roundals', 'mango', 'phirni', 'fritters', 'babycorn', 'stir-fry', 'dos', 'leches', 'kori', 'jhatpat', 'gulabjamun', 'pancake', 'raw', 'nadgir', 'gowa', 'tomato', 'capsicum', 'without', 'mooliradish', 'radish', 'bachka', 'jay', 'icecream', 'snack', 'fry', 'achaar', 'pickle', 'sutarfeni', 'patis', 'pepper', 'kuzhambu', 'drychicken', 'chetinad', 'bottle', 'peas', 'paneer', 'goan', 'curry', 'kadamba', 'puliodarai', 'more', 'made', 'leftover', 'nutritious', 'beet', 'raita', 'dosa', 'sambhar', 'nutritious', 'tikkas', 'ultimate', 'kid', 'kulcha', 'breaded', 'prawns', 'chana', 'daal', 'bajji', 'palak', 'poakodi', 'noodles', 'burger', 'tasty', 'chanagalu', 'cauli-cap', 'sabzi', 'minute', 'theeyal', 'broken', 'wheat', 'makai', 'na', 'sandiwich', 'veggie', 'all', 'dal', 'rolls', 'angle', 'maida', 'pakora', 'shake', 'challa', 'pindi', 'samia', 'punugulu', 'uuli', 'pachadi', 'diet', 'pizza', 'oriddhallchutney', 'aaloo', 'nayak', 'aloo', 'pudhina', 'raitha', 'avalpayasam', 'chilly', 'beet', 'root', 'pakodared', 'pakoda', 'methi', 'subji', 'ukdiche', 'modak', 'uppama', 'nemona', 'greenpeas', 'bombay', 'rawa', 'chatpate', 'ravaidli', 'easiest', 'corns', 'kebabs', 'cumin', 'falafel', 'chakli', 'tandoori', '7cups', 'karanji', 'french', 'pineapple', 'sponge', 'vanilla', 'ice', 'cream', 'aviyal', 'moon', 'puranpoli', 'chat', 'candy', 'cookie', 'drops', 'mud', 'pudding', 'sweetcorn', 'sabji', 'instant', 'gajar', 'halwa', 'sabudana', 'quesadilla', 'vusali', 'churmuri', 'left', 'over', 'rotli', 'dry', 'dhokli', 'chewda', 'teen', 'daale', 'chapathi', 'chat', 'gobi', 'machurian', 'tommotobath', 'toma', 'mongdal', 'appe', 'akki', 'vusali', 'south', 'fishcurry', 'karela', 'south', 'veg.', 'puneri', 'beet-root', 'batata', 'shirkhurma', 'tikki', 'dondakaya', 'breadupma', 'ripe', 'sambar', 'waldorf', 'tawa', 'rings', 'mouse', 'harabhara', 'prawns_masala_curry', 'besan', 'uttapam', 'vegetables', 'veggie-ribbon', 'toss', 'cookies', 'n', 'mikshakes', 'bonda', 'weight', 'loss', 'power', 'packed', 'coimbatore', 'special', 'pasta', 'primavera', 'baigan', 'bake', 'sambal', 'chocolate', 'tavellota', 'appam', 'paruppu', 'orundai', 'kozhambhu', 'one', 'minuit', 'maida', 'halwa', 'bindi', 'crisp', 'flour', 'keema', 'bullets', 'murungai', 'thuvayal', 'pastry', 'sandwich', 'malai', 'biriyani', 'dates', 'laddu', 'adai', 'sour', 'onion', 'neeru', 'dpsa', 'over', 'rice', 'khichdi', 'thepla', 'khatte', 'achari', 'lauki', 'lolipop', 'sev', 'pulav', 'mashroom', 'sooji', 'puda', 'oregano', 'ready', 'rava', 'palak', 'aur', 'ke', 'kofte', 'abc', 'paddu', 'zatpat', 'shev', 'bhaji', 'shashi', 'bhalla', 'chheth', 'dahi', 'sweet', 'roti', 'vegetable', 'palak-methi', 'palav', 'coconut', 'moong', 'mangalorean', 'pomfret', 'mangalorean', 'cashewkismi', 'ma', 'zeera-miri', 'mang', 'zeerey', 'meeri', 'kunukku', 'ladoo', 'avalakki', 'guard', 'okra', 'koozhu', 'infant', 'jackfruit', 'podimas', 'singaporean', 'summer', 'cool', 'mutton', 'currydry', 'delicasy', 'dhomsi', 'roll', 'banana', 'jelly', 'halubai', 'pumpkin', 'huliavalakki', 'healthy', 'chessey', 'cooler', 'calorie', 'pav', 'paanch', 'mishali', 'torkari', 'receipe', 'delight', 'rehana', 'lassi', 'janthikalu', 'navratri', 'spl', '-kele', 'kofte', 'mysore', 'vrat', 'chawal', 'chatpata', 'kachori', 'navratri', 'dryfruits', 'khe', 'paneer', 'tamoto', 'fruits', 'bhurji', 'murg', 'malai', 'amritsari', 'kadhai', 'masala', 'zhinga', 'dhaba', 'style', 'khusbudar', 'punjabi', 'fry', 'masale', 'zhinge', 'tikki', 'chauli', 'bhaji', 'gobhi', 'dahi', 'matar', 'adraki', 'makhani', 'mexican', 'tomato', 'soup', 'thai', 'green', 'pakodi', 'kadhi', 'vegetable', 'stew', 'methi');
$recipe = strtolower(trim($recipe));
echo "recipe:" . $recipe;
echo "<br>________________ testttt<br>";
$rsp = explode(" ", $recipe);
foreach ($rsp as $key => $rs) {
    if (trim($rs) == 'chilli') {
        $rsp[$key] = 'chilly';
    }
    if (strlen(trim($rs)) < 1) {
        unset($rsp[$key]);
    }
}
$rsp = array_merge(array(), $rsp);
$tag_matched = array();

foreach ($rsp as $t) {
    if (in_array(trim($t), $tags)) {
        //echo "INN ARRAY";
        $tag_matched[] = trim($t);
    }
}
//$status = 1;
//print_r($tag_matched);
if (isset($tag_matched)) {
    echo "<br>query1:" . $query = "SELECT name,description FROM food WHERE  name like '" . mysql_real_escape_string($recipe) . "'  ";
    $result = mysql_query($query);
    echo "<br>mysql array:";
    echo "no.of.rows" . $val = mysql_num_rows($result);
    //print_r(mysql_fetch_array($result));

    while ($row = mysql_fetch_array($result)) {
        if ($val > 0) {
            $return_value = $row['name'] . "\n" . $row['description'];
            $return_title = $row['name'];
        }
    }
}

if (!$return_value) {
    echo "<br>query4:" . $query = "SELECT name,description FROM food WHERE  name like '%" . mysql_real_escape_string($recipe) . "%'  ";
    $result = mysql_query($query);
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_array($result);
        $return_value = $row['name'] . "\n" . $row['description'];
        $return_title = $row['name'];
    } else {
        while ($row = mysql_fetch_array($result)) {
            if (isset($row['name']) && isset($row['description'])) {
                $rest_name[] = $row['name'];
                $rest_description[] = $row['description'];
            }
        }
        $return_value = $rest_name[0] . "\n" . $rest_description[0];
        $return_title = $rest_name[0];
    }
}

if (!$return_value) {
    $query = "SELECT name,description FROM  food WHERE ";
    //var_dump($tag_matched);
    foreach ($tag_matched as $key => $u) {
        if ($key == 0) {
            $query .= "tag LIKE '%" . mysql_real_escape_string($u) . "%'";
        } else {
            if (isset($tag_matched[$key + 1]) == 0) {
                $query .= "and tag LIKE '%" . mysql_real_escape_string($u) . "%'";
            }
        }
    }
    echo "<br>query2:" . $query;
    $result = mysql_query($query);
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_array($result);
        $return_value = $row['name'] . "\n" . $row['description'];
        $return_title = $row['name'];
    } else {
        while ($row = mysql_fetch_array($result)) {
            if (isset($row['name']) && isset($row['description'])) {
                $rest_name[] = $row['name'];
                $rest_description[] = $row['description'];
            }
        }
        $return_value = $rest_name[0] . "\n" . $rest_description[0];
        $return_title = $rest_name[0];
    }
}
$return_value = trim($return_value);
if (!$return_value) {
    echo "InnnN";
    $tag_against = implode(" ", $tag_matched);
    echo "<br>query3:" . $query = "SELECT * FROM `food` WHERE MATCH(tag) AGAINST('$tag_against')";
    $result = mysql_query($query);
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_array($result);
        $return_value = $row['name'] . "\n" . $row['description'];
        $return_title = $row['name'];
    } else {
        while ($row = mysql_fetch_array($result)) {
            if (isset($row['name']) && isset($row['description'])) {
                $rest_name[] = $row['name'];
                $rest_description[] = $row['description'];
            }
        }
        $return_value = $rest_name[0] . "\n" . $rest_description[0];
        $return_title = $rest_name[0];
    }
}


//echo "<h3>return value is $return_value </h3>";
if ($recipe_status == true && isset($rest_name)) {
    echo "<br>-----rest value:<br>";
    print_r($rest_name);
    $res_return = "More Results:\n";
    $i = 1;
    $list = array();

    foreach ($rest_name as$key => $resp) {
        if ($i > 5)
            break;
        if (isset($resp) && isset($rest_name[$key])) {
//                    $options_list[] = strtoupper("View more results matching '$spell_checked'"); //Several results matching $word.View more options";
//                    $list[] = array("content" => $word, "type" => "disamb");
            $options_list[] = strtoupper($resp);
            $list[] = array("content" => "recipe " . $resp, "count" => $i);
//                    if ($free == false && ((($i + 1) > 5) || !isset($ext_response['model'][$key + 1])))
//                        $mob_return .= "--\nForward Lyrics to your lover! Sms LYRICS songname to 55444 @ Rs 1. For eg. LYRICS te amo.";
//                    else if ($free == true && ((($i + 1) > 5) || !isset($ext_response['model'][$key + 1])))
//                        $mob_return .= "--\nForward Lyrics to your lover! Sms LYRICS songname to 55444. For eg. LYRICS te amo.";
        }
        $i++;
    }
} else if ($free == false) {
    $res_return = $return_value;
    $v = 1;
    if (isset($rest_name)) {
//                $mob_return .= "\nOPTIONS (Reply with option, eg. 1):\n";
//                $mob_return .= strtoupper("$v. VIEW MORE RESULTS @Rs.1/query\n");
        $options_list[] = "VIEW MORE RESULTS ";
        $list[] = array("content" => "recipe of list $recipe", "count" => $v);
        $v++;
    } /* else {
      $mob_return .= "\nOPTIONS (Reply with option, eg. 1):\n";
      } */
} else if ($free == true) {
    $res_return = $return_value;
    if (isset($rest_name)) {
//                $mob_return .= "\nOPTIONS (Reply with option, eg. 1):\n";
        $options_list[] = strtoupper("VIEW MORE RESULTS");
        $list[] = array("content" => "recipe of list $recipe", "count" => 1);
//                $mob_return .= "--\nForward Lyrics to your lover! Sms LYRICS songname to 55444. For eg. LYRICS te amo.";
    }
}
$res_return = str_ireplace("<", "", $res_return);
$res_return = str_ireplace(">", "", $res_return);


echo "<h3>Return Title: $return_title</h3>";

//$current_file = "/recipe/$numbers";
$current_file = "food/description/name/$return_title";
$source_machine = "db";

echo "<br>RECIPE RETURN : $res_return";
var_dump($options_list);
var_dump($recipe_must);
if (!trim($res_return) && $recipe_must) {
    echo "<br>Inside recipe must";
    $res_return = 'sorry, no recipe found for ' . ucfirst($recipe);
    $to_logserver['isresult'] = 0;
    $free = true;
}

/* Going to include allmanip
  //file_put_contents(DATA_PATH . $current_file, $res_return);

  //$source_machine = $machine_id;
  $total_return = $res_return;

  //$add_below = "--\nForward Lyrics to your lover! Sms LYRICS songname to 55444. For eg. LYRICS te amo.";
  echo "<br>before cmore";
  var_dump($total_return);
  var_dump($options_list);
  var_dump($list);



  include 'cmore.php';
  echo "<br>after cmore";
  var_dump($total_return);
  var_dump($options_list);
  var_dump($list);

  $outs = serialize($list);
  foreach ($list as $l) {
  $l['count'] = mb_convert_encoding($l['content'], "UTF-8");
  }
  file_put_contents(DATA_PATH . "/lists/$numbers", $outs);
  $q = 'delete from lists where number="' . $numbers . '"';
  mysql_query($q) or trigger_error(mysql_error() . " in $q", E_USER_ERROR);

  $q = 'replace into lists (machine_id,number,query_id) VALUES ("' . $machine_id . '","' . $numbers . '","' . $query_id . '")';
  mysql_query($q) or trigger_error(mysql_error() . " in $q", E_USER_ERROR);
 */
?>