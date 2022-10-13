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
    public class CTablaFlexTime
    {
        public List<ETablaFlexTime> TablaFlexTime(SqlConnection con, Int32 post, String user, Int32 anhio, Int32 mes)
        {
            List<ETablaFlexTime> lETablaFlexTime = null;
            SqlCommand cmd = new SqlCommand("ASP_TABLA_FLEX_TIME", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETablaFlexTime = new List<ETablaFlexTime>();

                ETablaFlexTime obETablaFlexTime = null;
                while (drd.Read())
                {
                    obETablaFlexTime = new ETablaFlexTime();
                    obETablaFlexTime.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obETablaFlexTime.v_dni = drd["v_dni"].ToString();
                    obETablaFlexTime.i_semana = Convert.ToInt32(drd["i_semana"].ToString());
                    obETablaFlexTime.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obETablaFlexTime.v_descripcion = drd["v_descripcion"].ToString();
                    obETablaFlexTime.i_flex = Convert.ToInt32(drd["i_flex"].ToString());
                    obETablaFlexTime.v_flex = drd["v_flex"].ToString();
                    obETablaFlexTime.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obETablaFlexTime.i_zona = Convert.ToInt32(drd["i_zona"].ToString());
                    obETablaFlexTime.i_local = Convert.ToInt32(drd["i_local"].ToString());
                    obETablaFlexTime.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obETablaFlexTime.v_estado = drd["v_estado"].ToString();
                    obETablaFlexTime.v_color_estado = drd["v_color_estado"].ToString();
                    obETablaFlexTime.d_fregistro = drd["d_fregistro"].ToString();
                    obETablaFlexTime.d_faprobacion = drd["d_faprobacion"].ToString();
                    lETablaFlexTime.Add(obETablaFlexTime);
                }
                drd.Close();
            }

            return (lETablaFlexTime);
        }
    }
}