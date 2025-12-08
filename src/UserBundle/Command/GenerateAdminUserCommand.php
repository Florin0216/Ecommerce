<?php

namespace UserBundle\Command;

use AppBundle\Services\EntityService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use UserBundle\Services\UserService;

#[AsCommand(name: "user:generate-admin")]
class GenerateAdminUserCommand extends Command
{
    public function __construct(
        protected ParameterBagInterface $params,
        protected EntityService $entityService,
        protected UserService  $userService,
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $this->params->get('admin_user_username');
        $password = $this->params->get('admin_user_password');
        $email = $this->params->get('admin_user_email');

        $admin = $this->userService->newInstance(
            email: $email,
            username: $username,
            password: $password
        );

        $admin->setRoles(['ROLE_ADMIN']);

        $this->entityService->save($admin);

        return Command::SUCCESS;
    }

}
