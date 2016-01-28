<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AdminBundle\Entity\Admin;


/**
 * Class CreateAdminCommand
 * This command create a Admin User with an encoded password
 *
 * @package AdminBundle\Command
 */
class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:generate')
            ->setDescription('Generate an admin user with an encoded password')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The admin username'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'The raw admin password'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The admin email'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('password');
        $email = $input->getArgument('email');

        $admin = (new Admin())
            ->setUsername($username)
            ->setEmail($email)
        ;
        $encoder = $this->getContainer()->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($admin, $plainPassword);
        $admin->setPassword($encodedPassword);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($admin);
        $em->flush();

        $output->writeln(sprintf('Generating Admin User with username `s`, password `%s` and email `%s`', $username, $plainPassword, $email));
    }
}