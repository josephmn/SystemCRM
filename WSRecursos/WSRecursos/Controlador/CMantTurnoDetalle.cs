using System;
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
    public class CMantTurnoDetalle
    {
        public List<EMantenimiento> MantTurnoDetalle(SqlConnection con, Int32 post, String dni, String dia, Int32 semana, Int32 anhio, String horainicio, String horafin, String tolerancia, Int32 local, String user)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_TURNO_DETALLE", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@dia", SqlDbType.VarChar).Value = dia;
            cmd.Parameters.AddWithValue("@semana", SqlDbType.Int).Value = semana;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@horaini", SqlDbType.VarChar).Value = horainicio;
            cmd.Parameters.AddWithValue("@horafin", SqlDbType.VarChar).Value = horafin;
            cmd.Parameters.AddWithValue("@tolerancia", SqlDbType.VarChar).Value = tolerancia;
            cmd.Parameters.AddWithValue("@local", SqlDbType.Int).Value = local;
            cmd.Parameters.AddWithValue("@user", SqlDbType.Int).Value = user;

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