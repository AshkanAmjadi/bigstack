<?php


namespace App\facade\Notification;


use App\Models\AdminAllert;
use Modules\User\App\Models\User;
use Modules\User\App\Models\UserAllert;

class NotificationService
{



    public function getText($text, $data = [])
    {

//        if ($type == 'danger'){
//            $color = 'rose';
//        }elseif ($type == 'info'){
//            $color = 'amber';
//        }elseif ($type == 'secondary'){
//            $color = 'gray';
//        }elseif ($type == 'warning'){
//            $color = 'orange';
//        }elseif ($type == 'success'){
//            $color = 'emerald';
//        }

        $first = isset($data['first']) ? $data['first'] : '';
        $second = isset($data['second']) ? $data['second'] : '';
        $third = isset($data['third']) ? $data['third'] : '';

        $sessionList = htmlAlink(route('user-panel.logins'),'sessions',true);

        $texts = [
            'answerToComment' => "$third replied to your comment in $first: $second.",
            'commentDeleted' => "Your comment on $first: $second was not approved and has been deleted due to reasons stated in the site rules.",
            'commentDeactive' => "Your comment on $first: $second has been temporarily deactivated and is not being displayed.",
            'verifyComment' => "Your comment on $first: $second has been approved.",
            'verifyConversation' => "Your question with the topic: $first has been approved.",
            'conversationDeactive' => "Your question with the topic: $first has been temporarily deactivated and is not being displayed.",
            'answerToConversation' => "$first replied to your question: $second.",
            'conversationDeleted' => "Your question: $first was not approved and has been deleted due to reasons stated in the site rules.",
            'verifyAnswer' => "Your answer to the question: $first has been approved.",
            'answerDeactive' => "Your answer to the question: $first has been temporarily deactivated and is not being displayed.",
            'answerDeleted' => "Your answer to the question: $first was not approved and has been deleted due to reasons stated in the site rules.",
            'bestAnswer' => "Your answer to the question: $first has been marked as the best answer.",
            'mentionToUser' => "The user with ID: $second mentioned you in $first: $third.",
            'loginWithOtherIp' => "A login has been recorded from the IP address $first. If you believe this was not you, please go to $sessionList in your user panel and remove the relevant session as soon as possible.",
        ];

        return $texts[$text];

    }


    public function getAdminText($text, $data = [])
    {

        $first = isset($data['first']) ? $data['first'] : '';
        $second = isset($data['second']) ? $data['second'] : '';
        $third = isset($data['third']) ? $data['third'] : '';

        $texts = [
            'userAdded' => "You have a new user named: $first with mobile number or email: $second",
            'commentAdded' => "A new comment (content: $first) was posted by $second for $third.",
            'answerAdded' => "A new answer to the question: $first was posted by $second.",
            'conversationAdded' => "A new question titled: $first was posted by $second.",
        ];

        return $texts[$text];

    }

    public function user($user_id, $type, $text, $data = [])
    {

        $notif = $this->getText($text, $data);

        UserAllert::query()->create(['user_id' => $user_id, 'content' => $notif, 'type' => $type]);

    }

    public function admin($type, $text, $data = [])
    {

        $notif = $this->getAdminText($text, $data);

        AdminAllert::query()->create(['content' => $notif, 'type' => $type]);


    }

}
