<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetTokenForUserCommand extends Command
{
    protected static $defaultName = 'GetTokenForUser';
    protected $entityManager;
    protected $JWTTokenManager;

    public function __construct($name = null, EntityManagerInterface $entityManager, JWTTokenManagerInterface $JWTTokenManager)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->JWTTokenManager = $JWTTokenManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Get the JWT token for the user')
            ->addArgument('username', InputArgument::REQUIRED, 'Username of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        if (null === $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username])) {
            $io->error(sprintf("The provided user `%s` is not valid or is not registered", $username));
        }

        $io->note('Creating a token');

        $io->success(sprintf('Bearer %s.', $this->JWTTokenManager->create($user)));
    }
}
