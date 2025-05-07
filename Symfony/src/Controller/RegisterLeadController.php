<?php
namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegistroControllerv2 extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Obtener los datos JSON de la solicitud
        $data = json_decode($request->getContent(), true);
        
        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $patient = new Patient();
        $patient->setEmail($data['correo']);
        $patient->setDni($data['dni']);
        $patient->setPhone($data['telefono']);
        $patient->setFirstName($data['nombre']);
        $patient->setLastName($data['apellidos']);
        $patient->setBirthDate(new \DateTime($data['fechaNacimiento']));

        // Hashear la contraseña usando password_hash()
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $patient->setPassword($hashedPassword);
        $patient->setRoles(['ROLE_PATIENT']);

        // Si hay un número de seguro, se agrega al paciente
        if (isset($data['numeroSeguro'])) {
            $patient->setInsuranceNumber($data['numeroSeguro']);
        }

        // Persistir al paciente en la base de datos
        $entityManager->persist($patient);

        // Crear y persistir el perfil
        $profile = new Profile();
        $profile->setUser($patient);
        $profile->setName("Paciente creado");
        $profile->setSex("male"); // O podrías tomar este dato también del frontend si lo necesitas
        $profile->setWeightKg(70.00); 
        $profile->setHeightCm(170.00);
        $profile->setBloodType("O+"); 
        $profile->setAllergies("Ninguna"); 
        $profile->setIntolerances("Lactosa"); 
        $profile->setChronicConditions("Ninguna");
        $profile->setCreatedAt(new \DateTime());
        $profile->setUpdatedAt(new \DateTime());

        $entityManager->persist($profile);
        $entityManager->flush();

        return $this->json(['message' => 'Patient registered successfully'], Response::HTTP_CREATED);
    }
}
