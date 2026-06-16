<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Test;
use App\Models\Section;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['user_id'=>'admin','name'=>'Administrator','password'=>Hash::make('admin123'),'is_admin'=>true]);
        User::create(['user_id'=>'student01','name'=>'Test Student 1','password'=>Hash::make('1234')]);
        User::create(['user_id'=>'student02','name'=>'Test Student 2','password'=>Hash::make('1234')]);

        $test = Test::create(['title'=>'IELTS Academic Practice Test 1','description'=>'Full practice test with Listening, Reading, Writing & Speaking.']);

        $listening = Section::create(['test_id'=>$test->id,'type'=>'listening','title'=>'Listening','duration_minutes'=>30,'order'=>1,'content'=>'audio/listening.mp3']);

        $lData = [
            [1,"What is the guest's first name?",'fill_blank','Anubhat','Section 1: Questions 1–10'],
            [2,"What is the guest's date of birth?",'fill_blank','31st March 1972','Section 1: Questions 1–10'],
            [3,"Which country is the guest from?",'fill_blank','India','Section 1: Questions 1–10'],
            [4,"What is the guest's occupation?",'fill_blank','nursing','Section 1: Questions 1–10'],
            [5,"How many nights will the guest stay?",'fill_blank','two','Section 1: Questions 1–10'],
            [6,"What type of board does the guest want?",'fill_blank','half board','Section 1: Questions 1–10'],
            [7,"What food does the guest want to avoid?",'fill_blank','red meat','Section 1: Questions 1–10'],
            [8,"What type of room does the guest prefer?",'fill_blank','bedsit','Section 1: Questions 1–10'],
            [9,"Where is the hotel located?",'fill_blank','out of town','Section 1: Questions 1–10'],
            [10,"What is the booking reference number?",'fill_blank','67549','Section 1: Questions 1–10'],
            [11,"What is the main purpose of the talk?",'mcq','B','Section 2: Questions 11–20'],
            [12,"What does the speaker recommend visitors do first?",'mcq','B','Section 2: Questions 11–20'],
            [13,"How long has the park been open to the public?",'mcq','C','Section 2: Questions 11–20'],
            [14,"What is the most popular activity in the park?",'mcq','A','Section 2: Questions 11–20'],
            [15,"When is the best time to visit the park?",'mcq','C','Section 2: Questions 11–20'],
            [16,"Visitors can learn about growing __________ in the garden area.",'fill_blank','herbs','Section 2: Questions 11–20'],
            [17,"The guided tours are led by an experienced __________.",'fill_blank','park ranger','Section 2: Questions 11–20'],
            [18,"Visitors are asked not to drop __________ in the park.",'fill_blank','litter','Section 2: Questions 11–20'],
            [19,"The children's play area is located near the __________.",'fill_blank','lake','Section 2: Questions 11–20'],
            [20,"The picnic area is set in a pleasant __________.",'fill_blank','wooded area','Section 2: Questions 11–20'],
            [21,"What is the woman's main concern about the project?",'mcq','B','Section 3: Questions 21–25'],
            [22,"What does the tutor suggest they focus on?",'mcq','C','Section 3: Questions 21–25'],
            [23,"How will they divide the workload?",'mcq','B','Section 3: Questions 21–25'],
            [24,"What resource does the tutor recommend?",'mcq','B','Section 3: Questions 21–25'],
            [25,"When is the project deadline?",'mcq','B','Section 3: Questions 21–25'],
            [26,"Knowledge in an organization typically flows from a __________.",'fill_blank','central source','Section 4: Questions 26–30'],
            [27,"Informal learning often takes place through __________.",'fill_blank','conversations','Section 4: Questions 26–30'],
            [28,"Organizations need clear __________ for knowledge sharing.",'fill_blank','rules','Section 4: Questions 26–30'],
            [29,"The most effective teams tend to be __________.",'fill_blank','project-oriented','Section 4: Questions 26–30'],
            [30,"The speaker describes the new approach as __________.",'fill_blank','unusual','Section 4: Questions 26–30'],
        ];
        $lMcq = [
            11=>['A'=>'To welcome new employees','B'=>'To describe facilities available','C'=>'To explain safety procedures'],
            12=>['A'=>'Visit the gift shop','B'=>'Collect a map from reception','C'=>'Join a guided tour'],
            13=>['A'=>'Five years','B'=>'Ten years','C'=>'Over twenty years'],
            14=>['A'=>'Bird watching','B'=>'Cycling','C'=>'Walking'],
            15=>['A'=>'Spring','B'=>'Summer','C'=>'Autumn'],
            21=>['A'=>'The topic is too broad','B'=>'There is not enough time','C'=>'The resources are limited'],
            22=>['A'=>'The introduction','B'=>'The methodology','C'=>'The literature review'],
            23=>['A'=>'Each person does half','B'=>'Based on individual strengths','C'=>'Randomly assigned'],
            24=>['A'=>'A textbook','B'=>'A journal article','C'=>'An online database'],
            25=>['A'=>'Next week','B'=>'End of the month','C'=>'In two months'],
        ];
        foreach ($lData as [$num,$text,$type,$answer,$group]) {
            $q = Question::create(['section_id'=>$listening->id,'question_number'=>$num,'question_text'=>$text,'question_type'=>$type,'correct_answer'=>$answer,'group_label'=>$group,'order'=>$num]);
            if (isset($lMcq[$num])) foreach ($lMcq[$num] as $l=>$t) Option::create(['question_id'=>$q->id,'label'=>$l,'option_text'=>$t]);
        }

        $passage = "Passage 1: The Changing Role of University Self-Access Centres\n\nUniversity self-access centres were originally created as quiet places where students could study independently, use reference materials, and improve their academic skills. In many institutions, these centres consisted of little more than a room with bookshelves, a few desks, and perhaps some audio equipment for language practice. The primary aim was to provide a space where students could work at their own pace, away from the structured environment of the classroom.\n\nHowever, over the past two decades, the role of self-access centres has changed dramatically. The introduction of digital technology has transformed these spaces into modern learning hubs equipped with computers, high-speed internet, multimedia resources, and even virtual reality tools. Students today can access a vast range of online courses, interactive learning platforms, and collaborative software that were unimaginable just a generation ago.\n\nThis transformation has not been without its challenges. Some educators argue that the shift towards technology-driven learning has come at the expense of traditional academic support. They point out that many students still struggle with basic study skills such as note-taking, critical reading, and essay writing — skills that were once the core focus of self-access centres. Critics also suggest that the constant availability of digital distractions in these centres may actually hinder rather than help learning.\n\nOn the other hand, proponents of the modern self-access centre argue that technology has made learning more accessible and engaging. They highlight the benefits of self-paced online courses, which allow students to revisit difficult concepts as many times as needed. Furthermore, the integration of collaborative tools has enabled students to work together on projects regardless of their physical location, breaking down barriers to group learning.\n\nDespite these debates, most universities have embraced the digital transformation of their self-access centres. Research suggests that student satisfaction with these facilities has generally increased, particularly among younger students who are more comfortable with technology. However, surveys also indicate that students still value the availability of human support — tutors and advisors who can provide personalised guidance and encouragement.\n\nLooking ahead, the future of self-access centres is likely to involve a blend of technology and human interaction. Many institutions are now experimenting with hybrid models that combine digital resources with face-to-face support sessions. The challenge for universities will be to meet the evolving expectations of students while ensuring that fundamental academic skills are not neglected in the pursuit of technological innovation.\n\n\nPassage 2: Urban Green Spaces and Human Wellbeing\n\nThe relationship between urban green spaces and human wellbeing has been the subject of extensive research in recent years. Studies have consistently shown that access to parks, gardens, and other natural environments within cities can have significant positive effects on both physical and mental health. People who live near green spaces tend to report lower levels of stress, anxiety, and depression compared to those who do not.\n\nOne of the primary mechanisms through which green spaces benefit health is by encouraging physical activity. Parks and open areas provide safe, attractive environments for walking, jogging, cycling, and other forms of exercise. Research has found that people who live within a short walk of a park are more likely to meet recommended levels of physical activity than those who live further away.\n\nBeyond physical health, green spaces also contribute to mental wellbeing through what psychologists call attention restoration. The natural environment provides a contrast to the constant sensory stimulation of urban life, allowing the mind to rest and recover from mental fatigue. Even brief exposure to nature has been shown to improve mood and cognitive function.\n\nGreen spaces also play an important role in social cohesion. Parks serve as communal gathering places where people from different backgrounds can interact, fostering a sense of community and belonging. Research has shown that neighbourhoods with well-maintained green spaces tend to have stronger social networks and lower rates of crime.\n\nHowever, the benefits of urban green spaces are not distributed equally across society. Studies have revealed that disadvantaged communities often have less access to quality green spaces than wealthier areas. This environmental inequality has led to calls for more equitable urban planning policies.\n\nThe quality of green spaces matters as much as their quantity. Research suggests that factors such as biodiversity, the presence of water features, and the overall design of a space can significantly influence its impact on wellbeing.\n\nIn terms of environmental benefits, urban green spaces help to improve air quality by filtering pollutants and producing oxygen. They also help to regulate temperature in cities, reducing the urban heat island effect. Green spaces additionally play a role in managing stormwater runoff, reducing the risk of flooding.\n\nAs cities continue to grow, the need for thoughtful integration of green space into urban design has never been greater. Urban planners are increasingly recognising that parks and gardens are not luxuries but essential components of healthy, livable cities.\n\n\nPassage 3: The Evolution of Organizational Culture\n\nOrganizational culture refers to the shared values, beliefs, and practices that characterise a company or institution. It shapes how employees interact, make decisions, and approach their work.\n\nResearchers have identified several distinct types of organizational culture. A hierarchical culture emphasises formal structures, clear lines of authority, and well-defined procedures. A clan culture prioritises collaboration, mentoring, and a family-like atmosphere. Market cultures are results-oriented, focusing on competition and achievement, while adhocracy cultures value innovation, risk-taking, and flexibility.\n\nThe evolution of organizational culture has been shaped by broader social and economic changes. The industrial era favoured hierarchical cultures with rigid command-and-control structures. The knowledge economy saw a shift towards more collaborative and innovative cultures. Today, many organizations are experimenting with hybrid models.\n\nOne key challenge in managing organizational culture is the tension between maintaining core values and adapting to change.";

        $reading = Section::create(['test_id'=>$test->id,'type'=>'reading','title'=>'Reading','duration_minutes'=>60,'order'=>2,'content'=>$passage]);

        $rData = [
            [1,'What was the original purpose of self-access centres?','mcq','B','Passage 1: Questions 1–5 (MCQ)'],
            [2,'What has been the most significant change?','mcq','C','Passage 1: Questions 1–5 (MCQ)'],
            [3,'What criticism do some educators have?','mcq','A','Passage 1: Questions 1–5 (MCQ)'],
            [4,'What do proponents emphasise?','mcq','B','Passage 1: Questions 1–5 (MCQ)'],
            [5,'What about the future of self-access centres?','mcq','C','Passage 1: Questions 1–5 (MCQ)'],
            [6,'Self-access centres have always had digital technology.','true_false_ng','FALSE','Passage 1: Questions 6–9 (T/F/NG)'],
            [7,'Student satisfaction has generally increased.','true_false_ng','TRUE','Passage 1: Questions 6–9 (T/F/NG)'],
            [8,'All educators support the technology shift.','true_false_ng','FALSE','Passage 1: Questions 6–9 (T/F/NG)'],
            [9,'Self-access centres started in the 1950s.','true_false_ng','NOT GIVEN','Passage 1: Questions 6–9 (T/F/NG)'],
            [10,'Students still value human __________.','fill_blank','support','Passage 1: Questions 10–13 (Summary)'],
            [11,'The introduction of __________ technology transformed the spaces.','fill_blank','digital','Passage 1: Questions 10–13 (Summary)'],
            [12,'Traditional centres were away from the __________ environment.','fill_blank','classroom','Passage 1: Questions 10–13 (Summary)'],
            [13,'The challenge is to meet evolving __________.','fill_blank','expectations','Passage 1: Questions 10–13 (Summary)'],
            [14,'Main benefit of green spaces for physical health?','mcq','B','Passage 2: Questions 14–18 (MCQ)'],
            [15,'What is attention restoration?','mcq','C','Passage 2: Questions 14–18 (MCQ)'],
            [16,'Role of green spaces in communities?','mcq','C','Passage 2: Questions 14–18 (MCQ)'],
            [17,'Environmental concern about green spaces?','mcq','C','Passage 2: Questions 14–18 (MCQ)'],
            [18,'What about quality of green spaces?','mcq','B','Passage 2: Questions 14–18 (MCQ)'],
            [19,'People near green spaces report lower stress.','true_false_ng','TRUE','Passage 2: Questions 19–23 (T/F/NG)'],
            [20,'All communities have equal access.','true_false_ng','FALSE','Passage 2: Questions 19–23 (T/F/NG)'],
            [21,'Green spaces improve air quality.','true_false_ng','TRUE','Passage 2: Questions 19–23 (T/F/NG)'],
            [22,'Green spaces increase city temperature.','true_false_ng','FALSE','Passage 2: Questions 19–23 (T/F/NG)'],
            [23,'Green spaces help manage stormwater.','true_false_ng','TRUE','Passage 2: Questions 19–23 (T/F/NG)'],
            [24,'Green spaces encourage __________ activity.','fill_blank','physical','Passage 2: Questions 24–26 (Summary)'],
            [25,'They improve __________ by filtering pollutants.','fill_blank','air quality','Passage 2: Questions 24–26 (Summary)'],
            [26,'Thoughtful integration of green __________ is essential.','fill_blank','space','Passage 2: Questions 24–26 (Summary)'],
            [27,'Hierarchical culture','matching','D','Passage 3: Questions 27–30 (Matching)'],
            [28,'Clan culture','matching','B','Passage 3: Questions 27–30 (Matching)'],
            [29,'Market culture','matching','A','Passage 3: Questions 27–30 (Matching)'],
            [30,'Adhocracy culture','matching','C','Passage 3: Questions 27–30 (Matching)'],
        ];
        $rMcq = [
            1=>['A'=>'Replace classroom teaching','B'=>'Provide space for independent study','C'=>'Test students','D'=>'Offer entertainment'],
            2=>['A'=>'Larger rooms','B'=>'More staff','C'=>'Digital technology','D'=>'Longer hours'],
            3=>['A'=>'Students lost basic study skills','B'=>'Costs increased','C'=>'Tech unreliable','D'=>'Buildings outdated'],
            4=>['A'=>'Lower costs','B'=>'Greater accessibility and engagement','C'=>'Better exams','D'=>'Simpler admin'],
            5=>['A'=>'Fully automated','B'=>'Close down','C'=>'Blend tech with human support','D'=>'Return to traditional'],
            14=>['A'=>'Better sleep','B'=>'Encouraging physical activity','C'=>'Reducing pollution','D'=>'Providing shade'],
            15=>['A'=>'Meditation','B'=>'Medical treatment','C'=>'Recovery from mental fatigue via nature','D'=>'Physical therapy'],
            16=>['A'=>'Increase property values','B'=>'Provide employment','C'=>'Foster social cohesion','D'=>'Attract tourists'],
            17=>['A'=>'Require too much water','B'=>'Increase crime','C'=>'Access unequally distributed','D'=>'Expensive'],
            18=>['A'=>'Quantity more important','B'=>'Quality significantly affects wellbeing','C'=>'All equal','D'=>'Size most important'],
        ];
        $matchOpts = ['A'=>'Results-oriented, competition','B'=>'Collaborative, family-like','C'=>'Innovation and flexibility','D'=>'Formal structures, authority'];

        foreach ($rData as [$num,$text,$type,$answer,$group]) {
            $q = Question::create(['section_id'=>$reading->id,'question_number'=>$num,'question_text'=>$text,'question_type'=>$type,'correct_answer'=>$answer,'group_label'=>$group,'order'=>$num]);
            if (isset($rMcq[$num])) foreach ($rMcq[$num] as $l=>$t) Option::create(['question_id'=>$q->id,'label'=>$l,'option_text'=>$t]);
            if ($type==='matching') foreach ($matchOpts as $l=>$t) Option::create(['question_id'=>$q->id,'label'=>$l,'option_text'=>$t]);
        }

        Section::create(['test_id'=>$test->id,'type'=>'writing','title'=>'Writing','duration_minutes'=>60,'order'=>3,
            'content'=>'The chart below shows the percentage of students using different study methods in a university in 2010, 2015, and 2025. Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
            'content_extra'=>'Some people believe that technology has made learning easier and more accessible, while others argue that it has reduced the quality of education. Discuss both views and give your own opinion.']);

        Section::create(['test_id'=>$test->id,'type'=>'speaking','title'=>'Speaking','duration_minutes'=>15,'order'=>4,
            'content'=>'Part 1: Introduction — Talk about your studies or work. Part 2: Cue Card — Describe a time when technology helped you learn something new. Part 3: Discussion — How has technology changed education in your country?']);
    }
}
