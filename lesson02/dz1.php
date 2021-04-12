<?php

abstract class Person
{
    public string $name;
    protected int $age;

    public function __construct(string $name, int $age)
    {
        $this->setName($name);
        $this->setAge($age);
    }

    public function setAge(int $age)
    {
        $this->age = $age;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class Pupil extends Person
{
    public function isAdult(): bool
    {
        return $this->age > 18;
    }
}

class Teacher extends Person
{
    private int $experience;

    public function __construct(string $name, int $age, int $experience)
    {
        parent::__construct($name, $age);
        $this->setExperience($experience);
    }

    public function setExperience(int $experience)
    {
        $this->experience = $experience;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }
}

class SchoolClass
{
    private Teacher $teacher;
    protected array $pupils;

    public function __construct(Teacher $teacher)
    {
        $this->setTeacher($teacher);
    }

    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    public function addPupil(Pupil $pupil): void
    {
        $this->pupils[] = $pupil;
    }
}

class School
{
    protected array $persons;
    protected array $classes;

    public function addPerson(Person $person): void
    {
        $this->persons[] = $person;
    }

    public function addClass(SchoolClass $class): void
    {
        $this->classes[] = $class;
    }

    public function personsInSchoolCount(): int
    {
        return count($this->persons);
    }
}
