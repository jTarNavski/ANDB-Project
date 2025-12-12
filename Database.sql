USE master;
GO

IF EXISTS (SELECT name FROM sys.databases WHERE name = N'Elearning')
BEGIN
    ALTER DATABASE Elearning SET SINGLE_USER WITH ROLLBACK IMMEDIATE;
    DROP DATABASE Elearning;
END
GO

CREATE DATABASE Elearning;
GO

IF NOT EXISTS (SELECT name FROM sys.server_principals WHERE name = 'UzytkownikStrony')
BEGIN
    CREATE LOGIN [UzytkownikStrony] WITH PASSWORD = N'YourStrongPassword123!', CHECK_EXPIRATION=OFF, CHECK_POLICY=OFF;
END
GO


USE Elearning;
GO


CREATE TABLE Users (
    Id INT IDENTITY(1,1) PRIMARY KEY,
    Username NVARCHAR(50) NOT NULL UNIQUE,
    PasswordHash NVARCHAR(255) NOT NULL,
    Role NVARCHAR(20) DEFAULT 'user',
    Email NVARCHAR(100),
    FullName NVARCHAR(100),
    Phone NVARCHAR(20),
    SocialMedia NVARCHAR(255),
    CreatedAt DATETIME DEFAULT GETDATE(),
    LastLogin DATETIME
);
GO

CREATE TABLE ActivityLog (
    LogId INT IDENTITY(1,1) PRIMARY KEY,
    UserId INT NOT NULL,
    Username NVARCHAR(50) NOT NULL,
    UserRole NVARCHAR(20),
    ActivityType NVARCHAR(50),
    LogDate DATETIME DEFAULT GETDATE()
);
GO

CREATE USER [UzytkownikStrony] FOR LOGIN [UzytkownikStrony];
GO

ALTER ROLE [db_owner] ADD MEMBER [UzytkownikStrony];
GO

// execute after registering user with admin1 username 
UPDATE Users
SET Role = 'admin'
WHERE Username = 'admin1';
GO
