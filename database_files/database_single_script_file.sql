USE [master]
GO
/****** Object:  Database [BestClothing]    Script Date: 4/27/2022 10:13:42 PM ******/
CREATE DATABASE [BestClothing]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'BestClothing', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\BestClothing.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'BestClothing_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\BestClothing_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [BestClothing] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [BestClothing].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [BestClothing] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [BestClothing] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [BestClothing] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [BestClothing] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [BestClothing] SET ARITHABORT OFF 
GO
ALTER DATABASE [BestClothing] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [BestClothing] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [BestClothing] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [BestClothing] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [BestClothing] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [BestClothing] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [BestClothing] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [BestClothing] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [BestClothing] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [BestClothing] SET  DISABLE_BROKER 
GO
ALTER DATABASE [BestClothing] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [BestClothing] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [BestClothing] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [BestClothing] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [BestClothing] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [BestClothing] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [BestClothing] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [BestClothing] SET RECOVERY FULL 
GO
ALTER DATABASE [BestClothing] SET  MULTI_USER 
GO
ALTER DATABASE [BestClothing] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [BestClothing] SET DB_CHAINING OFF 
GO
ALTER DATABASE [BestClothing] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [BestClothing] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [BestClothing] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [BestClothing] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'BestClothing', N'ON'
GO
ALTER DATABASE [BestClothing] SET QUERY_STORE = OFF
GO
USE [BestClothing]
GO
/****** Object:  User [ramesh]    Script Date: 4/27/2022 10:13:42 PM ******/
CREATE USER [ramesh] FOR LOGIN [ramesh] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  UserDefinedFunction [dbo].[DupUser]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[DupUser] (
	@username varchar(50),
	@email varchar(50)
)
RETURNS varchar(5) AS
BEGIN
	DECLARE @return_value varchar(5);
	SET @return_value = 'test';
    IF EXISTS (SELECT * FROM customers WHERE @email=email) SET @return_value = 'email';
    ELSE IF EXISTS (SELECT * FROM customers WHERE @username=username) SET @return_value = 'user';
	else set @return_value='none'
    RETURN @return_value
END;
GO
/****** Object:  Table [dbo].[customers]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[customers](
	[customer_id] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[username] [varchar](50) NOT NULL,
	[password] [varchar](250) NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[last_name] [varchar](50) NOT NULL,
	[address] [varchar](50) NULL,
	[email] [varchar](50) NULL,
 CONSTRAINT [PK_customers] PRIMARY KEY CLUSTERED 
(
	[customer_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[products]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[products](
	[prod_id] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[prod_itemid] [nchar](10) NULL,
	[prod_brand] [varchar](50) NULL,
	[prod_name] [varchar](250) NULL,
	[prod_price] [decimal](5, 2) NULL,
	[prod_img] [varchar](250) NULL,
	[featured] [char](1) NULL,
	[prod_category] [varchar](50) NULL,
 CONSTRAINT [PK_products] PRIMARY KEY CLUSTERED 
(
	[prod_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[User]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[User](
	[ID] [int] IDENTITY(1,1) NOT FOR REPLICATION NOT NULL,
	[Handle] [varchar](50) NULL,
	[PwHash] [varchar](250) NULL,
	[PwSalt] [varchar](250) NULL,
 CONSTRAINT [PK_User] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  StoredProcedure [dbo].[AddUser]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[AddUser] 
	@first_name varchar(50),  
	@last_name varchar(50),  
	@email varchar(50),
    @username varchar(50),  
	@password varchar(250)
AS    
    SET NOCOUNT ON;

    INSERT INTO customers (first_name,last_name,email,username,password)
	VALUES(@first_name,@last_name,@email,@username,@password)
    RETURN;
GO
/****** Object:  StoredProcedure [dbo].[CheckLogin]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[CheckLogin] 
    @username varchar(50)  

AS    
    SET NOCOUNT ON;

    SELECT password  
    FROM customers   
    WHERE username = @username;
    RETURN;
GO
/****** Object:  StoredProcedure [dbo].[getFeatured]    Script Date: 4/27/2022 10:13:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[getFeatured]  

AS    
    SET NOCOUNT ON;

    SELECT *  
    FROM products   
    RETURN;
GO
USE [master]
GO
ALTER DATABASE [BestClothing] SET  READ_WRITE 
GO
