<?php

echo "<h2>$req</h2>";
if ($spell_checked == "dhoom 3" || $spell_checked == "dhoom3") {
    $total_return = "Abhishek Bachchan and Uday Chopra will reprise their roles as Jai Dixit and Ali Akbar while Aamir Khan and Katrina Kaif form the antagonist duo. Aamir is a Thief mastermind, and disguise himself as a Joker whose working in a Circus.
- Written by Sayeid Faisal";

    $options_list[] = "Cast";
    $list[] = array("content" => "__dhoom3__cast__");

    $options_list[] = "showtime";
    $list[] = array("content" => "__dhoom3__showtime__");

    $options_list[] = "review";
    $list[] = array("content" => "__dhoom3__review__");

    $options_list[] = "dialogues";
    $list[] = array("content" => "__dhoom3__dialogues__");
} elseif (preg_match('~__dhoom3__(.+)__~', $req, $match)) {
    $opt = trim($match[1]);

    switch ($opt) {
        case 'cast':
            $total_return = "Credited cast:
Aamir Khan
Katrina Kaif
Tabrett Bethell
Kim DeJesus
Jennifer
Abhishek Bachchan
A.C.P. Jai Dixit
Bipasha Basu
Riya Ray
Uday Chopra
Elizabeth Reiners
Diana Penty
Selina Kapoor
Jacqueline Scislowski
M'laah Kaur Singh
Don Kress
Jackie Shroff
Berkeley Clayborne";

            break;
        case 'showtime':
            $total_return = "Select any city";

            $options_list[] = "kolkatta";
            $list[] = array("content" => "__showtime__kolkatta__");

            $options_list[] = "bangalore";
            $list[] = array("content" => "__showtime__bangalore__");

            $options_list[] = "ahmedabad";
            $list[] = array("content" => "__showtime__ahmedabad__");

            $options_list[] = "amritsar";
            $list[] = array("content" => "__showtime__amritsar__");

            $options_list[] = "badidi";
            $list[] = array("content" => "__showtime__badidi__");

            $options_list[] = "bhopal";
            $list[] = array("content" => "__showtime__bhopal__");

            $options_list[] = "calicut";
            $list[] = array("content" => "__showtime__calicut__");

            $options_list[] = "chennai";
            $list[] = array("content" => "__showtime__chennai__");

            $options_list[] = "guwahati";
            $list[] = array("content" => "__showtime__guwahati__");

            break;

        case 'review':
            $total_return = "Welcome to the flying world of YRF's Dhoom 3. I say so because here a motorbike can fly efficiently and if the need arises then it can also become a speed boat and if you push it further it can also function underwater. Well it's not just cool bikes even an auto rickshaw can fly here!
Vijay Kirshna Acharya's Dhoom 3 is another visual treat where you get to see a fancy foreign city, cool bikes, police cars and good stunts but that's about it. The Dhoom series theme music when clubbed with the action stunts in the latest installment provides some entertainment because what you end up watching is not all that bad. But if you are looking for any logic, you are watching the wrong film.
Sahir (Aamir Khan) loses his father because a Chicago bank doesn't allow him to continue his circus and asks him to shut shop. Since then his mission is to shut the bank down, he wouldn't settle for anything lesser! A talented circus boy grows up and continues to run the circus and rob the same bank living in the same city, but of course he is never caught because he is no less than a magician. Robberies are well planned and executed by him. In the United States no security agency has managed to catch him and no camera has captured his face while he is on the move. Post the robbery he returns to the circus as if nothing ever happened.
Since he leaves a message in Hindi each time he robs a bank the management calls for some help from India. ACP Jai Dixit (Abhishek Bachchan) and Ali Akbar (Uday Chopra) take charge of the case in Chicago and the local police take a back seat. As one would only guess, each time Sahir is one step ahead but what's surprising is how useless the entire security system is made to look. When Sahir hears of Jai's arrival, he immediately plans to meet him and take him into confidence which will help him understand his game-plan. Although what's questionable here is the very fact that why would a cop who is just handed over an important case come to trust an unknown person in an unknown country. It is far from my understanding at least.
As always you can make out Aamir Khan has worked hard for this particular role and it shows in many parts but it doesn't match to what Hrithik Roshan did in Dhoom 2. Neither does Aamir pull off the action very well nor the dance steps. Katrina Kaif plays Aaliya, Sahir's love interest; she has a very short role in the film. She puts a great show together in her opening scene and then she has very little to do. Abhishek Bachchan and Uday Chopra's famous chemistry from the previous films does show in some portions. Music by Pritam and Julius Packiam is below average. 
Dhoom 3 is full of loop holes, over-the-top acting and an overdose of action that doesn't fit well all the time. The timing is right so the film will run to packed houses but it's surely not a film that I would recommend as your last outing for 2013!
";
            break;

        case 'dialogues':

            $total_return = "Bande hain hum uske, hum pe kiska zor ... umeedo ke suraj, nikle chaaron aurr ... iraade hai fauladi, himmati har kadam ... apne haatho kismat likhne, aaj chale hain hum
Joh duniya ko namumkin lage ... wahi mauka hota hai ... kartab dikhane ka
Maskarre ka khel dhoke ka khel hota hai ... jis mein audience ko lagta hai ki jeet unki ho rahi hai ... lekin jeette hum hai, hamesha
Chor aur police ki sirf dushmani hoti hai";
            break;
        
        default:
            break;
    }
} elseif (preg_match('~__showtime__(.+)__~', $req, $match)) {
    $city = trim($match[1]);

    switch ($city) {
        case 'kolkata':
            $total_return = "Jaya Multiplex - Lake Town 10:45 AM 1:45 PM 4:50 PM 7:35 PM";
            break;

        case 'bangalore':
            $total_return = "Cinepolis - 10:00 AM 11:30 AM 1:30 PM 3:00 PM 5:00 PM 6:30 PM 8:30 PM 10:00 PM
Vision Cinemas 9:45 AM 12:55 PM 3:30 PM 6:45 PM 6:46 PM 10:00 PM
HMT Cinema 10:00 AM 1:00 PM 4:00 PM 7:00 PM
Vaibhav - Sanjay Nagar 11:00 AM 2:30 PM 6:00 PM 9:30 PM";
            break;

        case 'ahmedabad':
            $total_return = "Cinepolis - Ahmedabad 10:00 AM 10:30 AM 1:30 PM 2:00 PM 5:00 PM 5:30 PM 8:30 PM 9:00 PM";
            break;

        case 'amritsar':
            $total_return = "Cinepolis - Amritsar 10:00 AM 10:45 AM 1:30 PM 2:15 PM 5:00 PM 5:45 PM 8:30 PM 9:15 PM";
            break;
        case 'badidi':
            $total_return = "Sun City Cinemas - Baddi 10:00 AM 11:10 AM 1:00 PM 2:10 PM 4:10 PM 5:30 PM 7:20 PM 9:00 PM 10:20 PM";
            break;

        case 'bhopal':
            $total_return = "Cinepolis - Bhopal 9:01 AM 9:31 AM 10:01 AM 12:30 PM 1:00 PM 1:30 PM 4:00 PM 4:30 PM 5:00 PM 7:30 PM 8:00 PM 8:30 PM 11:00 PM";
            break;

        case 'calicut':
            $total_return = "Crown Theatre - Calicut 10:45 AM 2:15 PM 5:45 PM 9:15 PM";
            break;

        case 'chennai':
            $total_return = "Sangam Cinemas 11:30 AM 3:00 PM 6:30 PM 10:00 PM
Devi CinePlex 11:45 AM 3:30 PM 7:15 PM 10:30 PM";
            break;

        case 'guwahati':
            $total_return = "Anuradha Cineplex - Guwahati 10:00 AM 1:30 PM 5:00 PM 8:30 PM";
            break;

        default:
            break;
    }
}

if ($total_return) {
    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'dhoom3';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>
