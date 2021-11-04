<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->troncateTable([
            'proposals', //schedulings, customers, grades, admissions, journeys, feedings, uniforms, supplies, transports, extracurriculars
            'schedulings', //customers
            'voucherentrys', //facturations
            'facturations', //legalizations, autorizations
            'paids', //legalizations
            'legalizations', //students, attendants, grades, courses
            'listcourses', //grades, courses, students
            'trackingachievements', //weeklytrackings, achievements
            'weeklytrackings', //chronologicals, students, intelligences
            'consolidatedenrollments', //students
            'autorizations', //courses, students, attendants
            'observations_bulletin', //bulletins, observations
            'bulletins', //students,courses,periods
            'wallets', //students
            'consolide_achievements', //achievements, periods, courses
            'academicperiods', //courses
            'assistances', //courses
            'hoursweek', //activityclass, activityspaces, collaborators, courses
            'coursesconsolidated', //grades, courses, collaborators
            "periods", //grades
            "courses", //grades
            'chronologicals', //academicperiods, intelligences, collaborators
            "achievements", //intelligences
            'voucheregress', //providers
            "collaborators", //citys, locations, districts, documents, bloodtypes, professions
            "attendants", //citys, locations, districts, documents, bloodtypes, professions
            "students", //citys, locations, districts, documents, bloodtypes, healths
            "providers", //citys,locations, districts, documents
            'garden', //citys, locations, districts
            "districts", //locations
            "locations", //citys
            "users", //roles, permissions

            //SIN RELACIONES FORANEAS
            "permissions",
            "roles",
            "grades",
            "intelligences",
            "documents",
            "professions",
            "bloodtypes",
            "healths",
            "citys",
            'activityclass',
            'activityspaces',
            'customers',
            'documentsEnrollment',
            'admissions',
            'uniforms',
            'transports',
            'feedings',
            'extratimes',
            'journeys',
            'supplies',
            'extracurriculars',
            'observations'
        ]);

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        
        $this->call(CitySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(DistrictSeeder::class);
        
        $this->call(GradeSeeder::class);
        $this->call(CourseSeeder::class);
        
        $this->call(IntelligenceSeeder::class);
        $this->call(AchievementSeeder::class);
        
        $this->call(HealthSeeder::class);
        $this->call(BloodtypeSeeder::class);
        $this->call(ProfessionSeeder::class);
        $this->call(DocumentSeeder::class);
    }

    function troncateTable(array $tables){

    	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

    	foreach ($tables as $table) {
    		//Vaciar la tabla de los registros que tenga
    		DB::table($table)->truncate();
    	}
    	//Activa la revisión de llaves foraneas
    	DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
