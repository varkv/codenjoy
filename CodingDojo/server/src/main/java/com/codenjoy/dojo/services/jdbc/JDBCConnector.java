package com.codenjoy.dojo.services.jdbc;

/*-
 * #%L
 * Codenjoy - it's a dojo-like platform from developers to developers.
 * %%
 * Copyright (C) 2016 Codenjoy
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/gpl-3.0.html>.
 * #L%
 */


import java.sql.Connection;
import java.sql.DriverManager;

/**
 * Created by indigo on 2016-12-29.
 */
public class JDBCConnector {
    public static void main(String[] args) throws Exception {
        Class.forName("org.postgresql.Driver");
        String url = "jdbc:postgresql://[::1]:5432/tetrisj_codenjoy_contest?user=postgres&password=postgres";
        Connection connection = DriverManager.getConnection(url);
        connection.close();
        System.out.println("Ok!");
    }
}
