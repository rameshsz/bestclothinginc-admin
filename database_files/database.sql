USE [BestClothing]
GO
/****** Object:  User [ramesh]    Script Date: 4/25/2022 8:23:51 PM ******/
CREATE USER [ramesh] FOR LOGIN [ramesh] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  UserDefinedFunction [dbo].[DupUser]    Script Date: 4/25/2022 8:23:51 PM ******/
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
/****** Object:  Table [dbo].[customers]    Script Date: 4/25/2022 8:23:51 PM ******/
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
/****** Object:  Table [dbo].[products]    Script Date: 4/25/2022 8:23:51 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[products](
	[prod_id] [int] IDENTITY(1,1) NOT NULL,
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
/****** Object:  Table [dbo].[User]    Script Date: 4/25/2022 8:23:51 PM ******/
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
/****** Object:  StoredProcedure [dbo].[AddUser]    Script Date: 4/25/2022 8:23:51 PM ******/
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
/****** Object:  StoredProcedure [dbo].[CheckLogin]    Script Date: 4/25/2022 8:23:51 PM ******/
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
