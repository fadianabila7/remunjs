import { TypeOrmModuleOptions } from '@nestjs/typeorm';

export const databaseConfig: TypeOrmModuleOptions = {
  type: 'mysql',
  host: 'localhost',
  port: 3306,
  username: 'root',
  password: '',
  database: 'ci4_remundev',
  entities: [__dirname + '/../**/*.entity{.ts,.js}'],
  synchronize: true, // Jangan gunakan synchronize: true di production
};