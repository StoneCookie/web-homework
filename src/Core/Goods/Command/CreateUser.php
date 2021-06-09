<?php

declare(strict_types=1);

namespace App\Core\Goods\Command;

use App\Core\Goods\Document\User;
use App\Core\Goods\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{
    protected static $defaultName = 'app:core:create-user-goods';

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addOption('firstName',   null, InputOption::VALUE_OPTIONAL, 'First name')
            ->addOption('lastName',    null, InputOption::VALUE_OPTIONAL, 'Last name')
            ->addOption('age',         null, InputOption::VALUE_OPTIONAL, 'Age')
            ->addOption('phone',       null, InputOption::VALUE_OPTIONAL, 'Phone')
            ->addOption('email',       null, InputOption::VALUE_OPTIONAL, 'Email')
            ->addOption('dateOfBirth', null, InputOption::VALUE_OPTIONAL, 'Date of birth')
            ->addOption('regDate',     null, InputOption::VALUE_OPTIONAL, 'Registration date')
            ->addOption('cityUser',    null, InputOption::VALUE_OPTIONAL, 'City')
            ->addOption('rating',      null, InputOption::VALUE_OPTIONAL, 'Rating')
            ->addOption('status',      null, InputOption::VALUE_OPTIONAL, 'Status')
            ->addOption('roles',       null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Roles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($user = $this->userRepository->findOneBy(['phone' => $input->getOption('phone')])) {
            $output->writeln(
                [
                    'User already exists!',
                    '============',
                    $this->formatUserLine($user),
                ]
            );

            return Command::SUCCESS;
        }

        $user = new User(
            $input->getOption('firstName'),
            $input->getOption('lastName'),
            $input->getOption('age'),
            $input->getOption('phone'),
            $input->getOption('email'),
            $input->getOption('dateOfBirth'),
            $input->getOption('regDate'),
            $input->getOption('cityUser'),
            $input->getOption('rating'),
            $input->getOption('status'),
            $input->getOption('roles')
        );
        $user->setFirstName($input->getOption('firstName'));
        $user->setLastName($input->getOption('lastName'));
        $user->setAge($input->getOption('age'));
        $user->setPhone($input->getOption('phone'));
        $user->setEmail($input->getOption('email'));
        $user->setDateOfBirth($input->getOption('dateOfBirth'));
        $user->setRegDate($input->getOption('regDate'));
        $user->setCityUser($input->getOption('cityUser'));
        $user->setRating($input->getOption('rating'));
        $user->setStatus($input->getOption('status'));
        $user->setRoles($input->getOption('roles'));


        $this->userRepository->save($user);

        $output->writeln(
            [
                'User is created!',
                '============',
                $this->formatUserLine($user),
            ]
        );

        return Command::SUCCESS;
    }

    private function formatUserLine(User $user): string
    {
        return sprintf(
            'id: %s, firstName: %s, lastName: %s, age: %s, phone: %s, email: %s, dateOfBirth: %s, regDate: %s, cityUser: %s, rating: %s, status: %s, roles: %s',
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getPhone(),
            $user->getEmail(),
            $user->getDateOfBirth(),
            $user->getRegDate(),
            $user->getCityUser(),
            $user->getRating(),
            $user->getStatus(),
            implode(',', $user->getRoles()),
        );
    }
}
