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
    public class CControlFlexTime
    {
        public List<EControlFlexTime> ControlFlexTime(SqlConnection con, String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlFlexTime> lEControlFlexTime = null;
            SqlCommand cmd = new SqlCommand("ASP_CONTROL_TABLA_FLEX_TIME", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dnijefe", SqlDbType.VarChar).Value = dnijefe;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEControlFlexTime = new List<EControlFlexTime>();

                EControlFlexTime obEControlFlexTime = null;
                while (drd.Read())
                {
                    obEControlFlexTime = new EControlFlexTime();
                    obEControlFlexTime.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEControlFlexTime.v_dni = drd["v_dni"].ToString();
                    obEControlFlexTime.v_nombre = drd["v_nombre"].ToString();
                    obEControlFlexTime.i_semana = Convert.ToInt32(drd["i_semana"].ToString());
                    obEControlFlexTime.v_descripcion = drd["v_descripcion"].ToString();
                    obEControlFlexTime.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obEControlFlexTime.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obEControlFlexTime.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEControlFlexTime.v_estado = drd["v_estado"].ToString();
                    obEControlFlexTime.v_color = drd["v_color"].ToString();
                    obEControlFlexTime.SEMANA1 = drd["SEMANA1"].ToString();
                    obEControlFlexTime.SEMANA2 = drd["SEMANA2"].ToString();
                    obEControlFlexTime.SEMANA3 = drd["SEMANA3"].ToString();
                    obEControlFlexTime.SEMANA4 = drd["SEMANA4"].ToString();
                    obEControlFlexTime.SEMANA5 = drd["SEMANA5"].ToString();
                    obEControlFlexTime.d_faprobacion = drd["d_faprobacion"].ToString();
                    lEControlFlexTime.Add(obEControlFlexTime);
                }
                drd.Close();
            }

            return (lEControlFlexTime);
        }
    }
}