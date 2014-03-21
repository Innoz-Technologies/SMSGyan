<?php

if (preg_match("~\b^(lucky|bday|lucky number|birthday|blk|luck)\b~", $req)) { 


    $spell_checked = trim(str_replace("/", " ", $spell_checked));
    $spell_checked = trim(str_replace("-", " ", $spell_checked));
    $spell_checked = trim(str_replace(".", " ", $spell_checked));
    $spell_checked = trim(str_replace("th", "", $spell_checked));
    $spell_checked = trim(str_replace("lucky", "", $spell_checked));
    $spell_checked = trim(str_replace("bday", "", $spell_checked));
    $spell_checked = trim(str_replace("lucky number", "", $spell_checked));
    $spell_checked = trim(str_replace("birthday", "", $spell_checked));
    $spell_checked = trim(str_replace("blk", "", $spell_checked));

//$spell_checked = trim(str_replace(" ", "", $spell_checked));
    $arDate = matchdate($spell_checked);
    var_dump($arDate);
    if (!empty($arDate[2])) {
        $month = $arDate[1];
        $month = explode(" ", $month);
//        $month = explode(" ", $month);
        echo "<h2>Month</h2>";
        var_dump($month);
        echo "<h3>MONTH:<h3>" . $month[1];

        if (!is_numeric($month[0])) {
            $lucky_no = $month[1];
        } else {

            switch ($month[1]) {
                case 'january':
                case'jan':
                    $month[1] = '01';
                    break;
                case 'february':
                case'feb':
                    $month[1] = '02';
                    break;
                case 'march':
                case'mar':
                    $month[1] = '03';
                    break;
                case 'april':
                case'apr':
                    $month[1] = '04';
                    break;
                case 'may':
                    $month[1] = '05';
                    break;
                case 'june':
                case'jun':
                    $month[1] = '06';
                    break;
                case 'july':
                case'jul':
                    $month[1] = '07';
                    break;
                case 'august':
                case'aug':
                    $month[1] = '08';
                    break;
                case 'september':
                case'sep':
                    $month[1] = '09';
                    break;
                case 'october':
                case'oct':
                    $month[1] = '10';
                    break;
                case 'november':
                case'nov':
                    $month[1] = '11';
                    break;
                case 'december':
                case'dec':
                    $month[1] = '12';
                    break;
                default :
                    break;
            }
            if (empty($month[2]))
                $month[2] = '0000';
            $spell_checked = $month[0] . $month[1] . $month[2];
            $lucky_no = $month[0];
        }
    }


//$spell_checked = trim(str_replace("th", "", $spell_checked));
//$arDate = matchdate($spell_checked);




    echo $spell_checked;

    if (preg_match("~\b(([\d]{1})|([\d]{1,2})([\d]{1,2})([\d]{0,4}))\b~", $spell_checked, $match) && empty($lucky_no)) {
        var_dump($match);

        echo "<h2>Lucky $match[0],$match[4]</h2>";
        if (empty($lucky_no)) {
            $lucky_no = $match[0];
        }
    }
    switch ($lucky_no) {
        case '1':
        case'01':
        case'10':
        case '19':
        case'28':
            $total_return = "You are smart, straight talking, funny,stubborn, hardworking, honest,Jealous on competing basis, kind hearted,angry, friendly, authorities,Famous person...always want to be and regarded as first on people position,they are often like to be independent,will never be under others, self confident people!
                            You are most likely to fall in love in the younger age, but will get marry when you mature! You are likely to have problems with people who have
                            opposite views And you are most likely to take revenge over your enemies in a long time basis. You are a spender, but you will have a good profession in the
                            future. If you are guy you will be very popular that everybody will have mental attraction and respect at you. You can go anywhere from the local shop to the heart of the parliament because you are positive and well talented in numerous issues!! But in your life you will always have some people who will work hard to bring you & your name down.This is undercover!! Coz of your smart behavior you will be hated by some people too... Your family life is very cool, you will have a very nice partner & wonderful children...
                            You are pioneer,independent & original... Your best match is 4,6,8 good match is 3,5,7 !!! 
                            ";
            break;

        case '2':
        case'02':
        case'11':
        case '20':
        case'29':
            $total_return = "No matter what, you will be loved by every one coz your ruler is the moon and every one loves the Moon. Well.. 
                             You are a person who day dream a lot, you have very low-self confidence, you need back up for every move in your life, you are very much unpredictable. Means you do change according to time and circumstances, kind a selfish, have a very strong sense of musical, artistic talent, verbal communication. Your attitudes are like the Moon, comes to gloom and fade away so everybody can expect changes in you. You can be a next Mahatma Gandhi who does peace love or you can be a Hitler who wants to destroy the man kind and peace (I mean in the community and your own home). 
                             If you really have a deep thought about your own believe in God you can feel the difference which will make you stronger! Most of the time your words are a kind of would be happening true! 
                             So without any knowledge you can predict the situation. You will become poets, writers, any Artistic business people! You are not strong in love, so you will be there and here till you get marry.. 
                             If U r a girl you will be a responsible woman in the whole family. 
                             If U r a man you will involve in fights & arguments in the family or Vice-versa. Means you will sacrifice your life for the goodness sake of Your family...You are gentle , intuitive with a broad vision, a power behind the scenes, well balanced People!!! Your best match is 2 ,5 ,9 no other people can put up with you !!!  
                            ";
            break;
        case '3':
        case'03':
        case'12':
        case '21':
        case'30':
            $total_return = "You are a person of hard hearted, selfish most of the times, religious, loves to climb up in your life.
                                You always tend to have lots of problems within your family in the early stages but you will put up with everything..
                                You have the strong word power, pretty happy face.. So wherever you go always you have got what you wanted!!!
                                And from the birth always wanted to work hard in order to achieve something.. You will not get anything without hard work! 
                                When you reach a man/ woman age you want other younger once to listen to you because you want younger people to respect people older than them.
                                You do set so many examples to others. Generally you are not a cool person. It's not easy thing dealing with you. 
                                A tough player you are! But once you like someone's attitude then here you go, what can I say? It will be a lasting friendship.
                                You always have respect from others. Your life seems to have lots of worries and problems but sure they won't be long.. you will always have brilliant kids!!!
                                You love the money a bit too much so temptation will push you to endless trying and trying..
                                If you are a guy then it's over. Looking after your family and help friends, so you will spend a life time just being generous and kind (except 21st born men).
                                And number 3s you will be such an example of how to be in the culture & life!!! If you are girl then you have good character and culture & hardworking attitude.
                                You always follow. You are a freedom lover, creative, ambition focused, a person who brings beauty, hope & joy to this world!!! 
                                Your best match 6 ,9. Good match 1 ,3 ,5 !!! !!! 
                            ";
            break;
        case '4':
        case'04':
        case'13':
        case '22':
        case'31':
            $total_return = "You are very popular within the community, you can get things done by just chatting..to even enemies!
                                You have a pretty good business mind, you are often have no-idea what is today is like, or tomorrow is like, you are a person who does anything when your head thinks lets do this.
                                You will be famous if you open up a business, get involve in share dealings, music etc..
                                Very popular with sense of humor ,you are the one your friends and families will always ask for help, and you are the one actually get money on credit and help your friends.
                                You will have more than 1 relationship, but when u get settle down you will be a bit selfish anyway.
                                Coz your other half will have a pretty good amount of control in you, be careful! You tend to go for other relationships!
                                Contacts even you are married at times 'coz your popularity..
                                You are someone who get along with anyone coz the number 5 is the middle number..
                                Changes & freedom lovers you are! You are an explorer with magic on your face. You learn your life through experience and it's your best teacher!!!
                                Your best match 1 ,2 ,9. Good match 6 ,8 !!!";
            break;
        case '5':
        case'05':
        case'14':
        case '23':
            $total_return = "You are very popular within the community, you can get things done by just chatting..to even enemies!
                            You have a pretty good business mind, you are often have no-idea what is today is like, or tomorrow is like, you are a person who does anything when your head thinks lets do this.
                            You will be famous if you open up a business, get involve in share dealings, music etc..
                            Very popular with sense of humor ,you are the one your friends and families will always ask for help, and you are the one actually get money on credit and help your friends.
                            You will have more than 1 relationship, but when u get settle down you will be a bit selfish anyway.
                            Coz your other half will have a pretty good amount of control in you, be careful! You tend to go for other relationships!
                            Contacts even you are married at times 'coz your popularity..
                            You are someone who get along with anyone coz the number 5 is the middle number..
                            Changes & freedom lovers you are! You are an explorer with magic on your face. You learn your life through experience and it's your best teacher!!!
                            Your best match 1 ,2 ,9. Good match 6 ,8 !!! 
                            ";
            break;
        case '6':
        case'06':
        case'15':
        case '24':
            $total_return = "Ooopppss..you are born to enjoy.. You don't care about others.
                            I mean you are always want to enjoy your life time, you are a person.. You will be very good in either education or work wise or business management!
                            You are talented, kind (but with only people who you think are nice), very beautiful girls and guys, popular and more than lucky with anything in your lives.
                            All the goodness does come with you. Your mind and body is just made perfect for love. You are lovable by any other numbers.
                            But if you are a number 6 man, you will experience kind of looks from most girls and will involve in more than few relationships until you get married.
                            If you are girl, most of you will get marry/engaged early. You are a caring person towards your family & friends .
                            If you miss the half-way mark then you are about to suffer physically and mentally.
                            Generally you will lead a very good inner-home happiness with nothing short of. 
                            You are a person of compassion, comfort & fairness, domestic responsibility, good judgment, and after all you can heal this world wounds to make peace for every life coz you have the great power of caring talent to make this world of love one step further...
                            Your best match 1, 6, 9. Good match 4, 5 !!! 
                            ";
            break;
        case '7':
        case'07':
        case'16':
        case '25':
            $total_return = "You have got the attraction to anyone out there, you are realistic, very confident, happy, such a talented individual with your education, music, arts, singing, and most importantly acting too.
                            You have real problems with bad temper! If you are a girl, you are popular with the subjects listed above.
                            You give up things for your parents. I mean you value your family status a lot, you will be in the top rank when you reach a certain age.
                            If you are a guy you are popular with girls, you are a very talented too. Most of the number 7s face lots of problems with their marriage life.
                            Only a very few are happy. You have everything in your life, but still always number 7s have some sort of unfullfilness, such worries all their lifetime.
                            It's probably the Lord given you all sort of over the standard humans talents and you are about to suffer in family life.
                            So you need to get ready looking for a partner rather than waiting. If you don't, then you might end-up single.
                            So take care with this issue, ok? You are wonderful, friendly, artistic, happy person.. You are born to contribute lots to this world!!!
                            Your best match is 2. Good matches are 1,4 !!! 
                            ";
            break;
        case '8':
        case'08':
        case'17':
        case '26':
            $total_return = "You are a very strong personality, there's no one out there will understand you.
                            You are very good at pointing your finger at some thing and say this is what.
                            You are more likely to suffer from the early ages.
                            I mean poverty. If your times are not good you might lose either of your parent and end up looking after your entire family.
                            You often suffer all the way in life. The problems will not allow you to study further, but you will learn the life in a very practical way.
                            You are the one who will fight for justice and may die in the war too.
                            You are normally very reserved with handful of friends and most of the time live life lonely and always prepared to help others. Well.
                            once you get married (which is often late) then your bad lucks will go away a bit and you! u become safe.
                            You will face un-expected problems such as : the error, government, poisonous animals, accidents.
                            You are some one with great discipline, persistence, courage, strength which will take you to success.
                            You are a great part of a family team. You are a fighter! Your Best match 1 ,4, 8. Good match 5 !!!
                            ";
            break;
        case '9':
        case'09':
        case'18':
        case '27':
            $total_return = "Hey...you guys are the incompatible people in the world.
                            You are so strong, physically and mentally... You are often have big-aims.
                            You will work hard and hard to get there. Normally you suffer in the early age from family problems and generally you will have fighting life..
                            But when you achieve what you have done, it's always a big task you have done!
                            You are so much respected in the community, you are a person who can make a challenge and successfully finish the matter off.
                            You are very naughty in your younger age, often beaten up by your parents and involve in fights and you seemed to have lots of injuries in your life time.
                            But when u grow you become calm and macho type. Love is not an easy matter for you.
                            You are good in engineering or banking jobs coz people always trust you.
                            Your family life is very good, but will have worries over your children.
                            Your such qualities are humanitarian, patient, very wise & compassionate.
                            You are born to achieve targets and serve every one all equally without any prejudice.
                            You are totally a role model to anybody in the world for a great inspiration.
                            ";

            break;

        default:
            break;
    }
    if (!empty($total_return)) {
        $source_machine = $machine_id;
        $current_file = "/temp/$numbers";
        file_put_contents(DATA_PATH . $current_file, $total_return);
        $to_logserver['source'] = 'lucky';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
