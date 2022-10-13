﻿using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CGestionVacaciones
    {
        public List<EMantenimiento> Listar_GestionVacaciones(SqlConnection con, Int32 codigo, String dni, Int32 indice)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_GESTION_VACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@codigo", SqlDbType.Int).Value = codigo;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@indice", SqlDbType.Int).Value = indice;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMantenimiento = new List<EMantenimiento>();

                EMantenimiento obEMantenimiento = null;
                while (drd.Read())
                {
                    obEMantenimiento = new EMantenimiento();
                    obEMantenimiento.v_icon = drd["v_icon"].ToString();
                    obEMantenimiento.v_title = drd["v_title"].ToString();
                    obEMantenimiento.v_text = drd["v_text"].ToString();
                    obEMantenimiento.i_timer = Convert.ToInt32(drd["i_timer"].ToString());
                    obEMantenimiento.i_case = Convert.ToInt32(drd["i_case"].ToString());
                    obEMantenimiento.v_progressbar = Convert.ToBoolean(drd["v_progressbar"].ToString());
                    lEMantenimiento.Add(obEMantenimiento);
                }
                drd.Close();
            }

            return (lEMantenimiento);
        }
    }
}