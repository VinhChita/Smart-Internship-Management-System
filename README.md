

# Smart Internship Management

## សេចក្តីណែនាំអំពីការដំឡើង និងរបៀបប្រើប្រាស់

### 1. អំពី Project

**Smart Internship Management** គឺជាប្រព័ន្ធគ្រប់គ្រងកម្មសិក្សា ដែលបង្កើតឡើងដោយប្រើ Laravel និង MySQL។ ឯកសារនេះណែនាំអំពីការដំឡើង Project ការបើកប្រព័ន្ធ និងរបៀបប្រើប្រាស់មុខងារសំខាន់ៗ។

> ចំណាំ៖ ឈ្មោះមុខងារ និងតួនាទីអ្នកប្រើប្រាស់ខាងក្រោម គឺជាគំរូ។ សូមកែឱ្យត្រូវនឹងមុខងារពិតក្នុង Project។

### 2. តម្រូវការមុនពេលដំឡើង

ត្រូវមានកម្មវិធីខាងក្រោម៖

- PHP ដែលត្រូវនឹង Laravel version របស់ Project
- Composer
- MySQL ឬ MariaDB
- Node.js និង npm ប្រសិនបើ Project ប្រើ Vite ឬ frontend assets
- Web browser ដូចជា Chrome ឬ Edge

### 3. របៀបដំឡើង Project

#### ជំហានទី 1៖ បើក Project

បើក Terminal ឬ Command Prompt ហើយចូលទៅកាន់ថត Project៖

```bash
cd path/to/Smart-Internship-Management
```

#### ជំហានទី 2៖ ដំឡើង PHP dependencies

```bash
composer install
```

#### ជំហានទី 3៖ បង្កើតឯកសារ Environment

ចម្លងឯកសារ `.env.example` ទៅជា `.env`៖

```bash
cp .env.example .env
```

នៅលើ Windows អាចប្រើ៖

```cmd
copy .env.example .env
```

#### ជំហានទី 4៖ បង្កើត Database

1. បើក MySQL ឬ phpMyAdmin។
2. បង្កើត Database ថ្មី ឧទាហរណ៍ `smart_internship_management`។
```cmd
CREATE DATABASE smart_internship CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
4. កែព័ត៌មាន Database នៅក្នុងឯកសារ `.env`៖

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_internship_management
DB_USERNAME=root
DB_PASSWORD=
```

សូមបញ្ចូល `DB_USERNAME` និង `DB_PASSWORD` ដែលត្រូវនឹង MySQL របស់អ្នក។

#### ជំហានទី 5៖ បង្កើត Application Key

```bash
php artisan key:generate
```

#### ជំហានទី 6៖ បង្កើត Tables ក្នុង Database

```bash
php artisan migrate
```

បើ Project មាន Seeder ហើយត្រូវការទិន្នន័យសាកល្បង៖

```bash
php artisan db:seed
```

ឬអាចប្រើ៖

```bash
php artisan migrate --seed
```

> **ប្រយ័ត្ន៖** កុំប្រើ `php artisan migrate:fresh` លើ Database ដែលមានទិន្នន័យសំខាន់ ព្រោះវាលុប Tables ចាស់ទាំងអស់ រួចបង្កើតឡើងវិញ។

#### ជំហានទី 7៖ ដំឡើង Frontend dependencies

បើ Project មាន `package.json` សូមដំណើរការ៖

```bash
npm install
npm run build
```

#### ជំហានទី 8៖ បើកប្រព័ន្ធ

```bash
php artisan serve
```

បើក Browser ហើយចូលទៅកាន់៖

```text
http://127.0.0.1:8000
```

### 4. របៀបប្រើប្រាស់ប្រព័ន្ធ

#### 4.1 ចូលប្រើប្រាស់

1. បើកគេហទំព័ររបស់ Project។
2. ចូលទៅកាន់ទំព័រ Login។
3. បញ្ចូល Email និង Password។
4. ចុចប៊ូតុង Login។
5. បន្ទាប់ពីចូលបាន ប្រព័ន្ធនឹងបង្ហាញទំព័រដែលសមស្របនឹងតួនាទីអ្នកប្រើប្រាស់។

#### 4.2 មុខងាររបស់ Admin

ប្រសិនបើ Project មានតួនាទី Admin អាចប្រើប្រាស់មុខងារដូចជា៖

1. ចូលប្រព័ន្ធដោយគណនី Admin។
2. ចូលទៅកាន់ Dashboard ដើម្បីមើលស្ថានភាពប្រព័ន្ធ។
3. គ្រប់គ្រងគណនីអ្នកប្រើប្រាស់។
4. បន្ថែម កែប្រែ ឬលុបទិន្នន័យដែល Admin មានសិទ្ធិគ្រប់គ្រង។
5. ពិនិត្យ និងគ្រប់គ្រងព័ត៌មានកម្មសិក្សា ឬពាក្យស្នើសុំ។
6. ចេញពីប្រព័ន្ធដោយចុច Logout។

#### 4.3 មុខងាររបស់ Student

ប្រសិនបើ Project មានតួនាទី Student អាចប្រើប្រាស់មុខងារដូចជា៖

1. ចុះឈ្មោះ ឬចូលប្រព័ន្ធ។
2. បំពេញ និងកែប្រែព័ត៌មានផ្ទាល់ខ្លួន។
3. មើលព័ត៌មានឱកាសកម្មសិក្សា។
4. ដាក់ពាក្យស្នើសុំកម្មសិក្សា ប្រសិនបើមានមុខងារនេះ។
5. ពិនិត្យស្ថានភាពពាក្យស្នើសុំ។
6. ចេញពីប្រព័ន្ធដោយចុច Logout។

#### 4.4 មុខងាររបស់ Company ឬ Supervisor

ប្រសិនបើ Project មានតួនាទី Company ឬ Supervisor អ្នកប្រើប្រាស់អាចចូលទៅពិនិត្យព័ត៌មានកម្មសិក្សា និងគ្រប់គ្រងសកម្មភាពដែលប្រព័ន្ធអនុញ្ញាត ដូចជា ពិនិត្យពាក្យស្នើសុំ ឬវាយតម្លៃនិស្សិត។

### 5. ដំណើរការប្រើប្រាស់ប្រព័ន្ធជាទូទៅ

1. Admin បង្កើត ឬរៀបចំព័ត៌មានកម្មសិក្សា។
2. Student ចូលប្រព័ន្ធ ហើយស្វែងរកឱកាសកម្មសិក្សា។
3. Student ដាក់ពាក្យស្នើសុំ ប្រសិនបើមានមុខងារនេះ។
4. អ្នកមានសិទ្ធិពិនិត្យពាក្យស្នើសុំ និងកំណត់ស្ថានភាព។
5. Student ពិនិត្យលទ្ធផល ឬស្ថានភាពពាក្យរបស់ខ្លួន។

### 6. ដោះស្រាយបញ្ហាទូទៅ

#### បញ្ហា Database connection

- ពិនិត្យថា MySQL កំពុងដំណើរការឬអត់។
- ពិនិត្យ `DB_DATABASE`, `DB_USERNAME` និង `DB_PASSWORD` ក្នុង `.env`។
- បន្ទាប់ពីកែ `.env` សូមសម្អាត Configuration Cache៖

```bash
php artisan config:clear
```

#### បញ្ហា Migration

ពិនិត្យថា Database មានរួចហើយ និងព័ត៌មាន `.env` ត្រឹមត្រូវ។ បន្ទាប់មកដំណើរការ៖

```bash
php artisan migrate
```

បើមាន Error សូមរក្សាទុកសារកំហុសទាំងមូល ដើម្បីពិនិត្យមូលហេតុ។

#### បញ្ហា Composer dependencies

```bash
composer install
```

#### បញ្ហា Frontend assets

បើ Project ប្រើ Vite សូមដំណើរការ៖

```bash
npm install
npm run build
```

### 7. បិទប្រព័ន្ធ

ដើម្បីបញ្ឈប់ Laravel development server សូមត្រឡប់ទៅ Terminal ដែលកំពុងដំណើរការ ហើយចុច៖

```text
Ctrl + C
```

### 8. ព័ត៌មានបន្ថែម

ឯកសារនេះជាសេចក្តីណែនាំទូទៅ។ សម្រាប់ឱ្យត្រឹមត្រូវតាម Project ពិត សូមបន្ថែម៖

- Laravel និង PHP version
- ឈ្មោះ Database
- គណនីសាកល្បងដែលបានកំណត់ក្នុង Project
- ឈ្មោះម៉ឺនុយ និងមុខងារពិតរបស់ Admin, Student និងតួនាទីផ្សេងៗ
- រូបភាពអេក្រង់ ឬជំហានប្រើប្រាស់សម្រាប់មុខងារនីមួយៗ

