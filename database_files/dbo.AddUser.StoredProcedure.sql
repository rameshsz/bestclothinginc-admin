USE [BestClothing]
GO
/****** Object:  StoredProcedure [dbo].[AddUser]    Script Date: 4/27/2022 10:01:32 PM ******/
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
