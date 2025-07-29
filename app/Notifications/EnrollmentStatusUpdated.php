<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Enrollment;

class EnrollmentStatusUpdated extends Notification
{
    use Queueable;

    public Enrollment $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // 👇 CORREÇÃO AQUI: Carregamos a relação 'schedule' e, dentro dela, 'subject'
        $this->enrollment->load(['schedule.subject', 'student']);
        
        // 👇 CORREÇÃO AQUI: Acessamos o nome da disciplina através da turma
        $subjectName = $this->enrollment->schedule->subject->name;
        $studentName = $this->enrollment->student->name;
        $status = $this->enrollment->status;

        $mailMessage = (new MailMessage)
                    ->subject('Atualização da sua Matrícula: ' . $subjectName);

        if ($status === 'approved') {
            $mailMessage
                ->greeting('Olá, ' . $studentName . '!')
                ->line('Ótima notícia! Sua matrícula na disciplina "' . $subjectName . '" foi APROVADA.')
                ->line('Você já pode visualizar esta turma no seu horário de aulas.')
                ->action('Ver Meu Horário', route('my-schedule.index'));
        } else { // 'rejected'
            $mailMessage
                ->greeting('Olá, ' . $studentName . '.')
                ->line('Houve uma atualização sobre sua solicitação de matrícula na disciplina "' . $subjectName . '".')
                ->line('Status: REJEITADA.')
                ->line('Para mais detalhes ou para tentar se inscrever em outra turma, acesse o portal.');
        }

        return $mailMessage->salutation('Atenciosamente, Equipe Gestão Acadêmica');
    }
}