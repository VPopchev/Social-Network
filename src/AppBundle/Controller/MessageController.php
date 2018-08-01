<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\MessageType;
use AppBundle\Service\MessageServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    /**
     * @var MessageServiceInterface
     */
    private $messageService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * MessageController constructor.
     * @param MessageServiceInterface $messageService
     */
    public function __construct(MessageServiceInterface $messageService,
                                UserServiceInterface $userService)
    {
        $this->messageService = $messageService;
        $this->userService = $userService;
    }

    /**
     * @Route("/sendNew")
     * @param Request $request
     * @return JsonResponse
     */
    public function newMessageAction(Request $request){
        $message = new Message();
        $email = $request->request->get('email');
        $title = $request->request->get('title');
        $content = $request->request->get('content');
        $sender = $this->getUser();
        $receiver = $this->userService->findByEmail($email);
        $message->setTitle($title);
        $message->setContent($content);
        $message->setReceiver($receiver);
        $this->messageService->send($message,$sender);
        return new JsonResponse($title,200);
    }

    /**
     * @param Request $request
     * @Route("message/send",name="send_message")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function sendAction(Request $request){
        return $this->render('message/messageForm.html.twig');
    }

    /**
     * @param Message $message
     * @Route("/readMessage/{id}",name="read_message")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction(Message $message){
        $this->messageService->setRead($message);
        return $this->render('message/read.html.twig',[
            'message' => $message
        ]);
    }

    /**
     * @Route("/inbox",name="inbox")
     */
    public function inboxAction(){
        /** @var User $user */
        $user = $this->getUser();
        /** @var Message[] $inbox */
        $inbox = $this->messageService->getUserInbox($user->getId());
        return $this->render('message/inbox.html.twig',[
            'messages' => $inbox
        ]);
    }


    /**
     * @Route("/outbox",name="outbox")
     */
    public function outboxAction(){
        /** @var User $user */
        $user = $this->getUser();
        /** @var Message[] $outbox */
        $outbox = $this->messageService->getUserOutbox($user->getId());
        return $this->render('message/outbox.html.twig',[
            'messages' => $outbox
        ]);
    }

    /**
     * @Route("/mailbox",name="mailbox")
     */
    public function mailBoxAction(){
        /** @var User $user */
        $user = $this->getUser();
        /** @var Message[] $inbox */
        $inbox = $this->messageService->getUserInbox($user->getId());
        return $this->render('message/box.html.twig',[
            'inbox' => $inbox,
            'user' => $user
        ]);
    }


    /**
     * @param Message $message
     * @Route("message/delete/{id}",name="delete_message")
     * @return JsonResponse
     */
    public function deleteAction(Message $message){
        $this->messageService->delete($message);
        return new JsonResponse(null, 200);
    }
}
