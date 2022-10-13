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
    public class CMantIndicadorPersonal
    {
        public List<EMantenimiento> MantIndicadorPersonal(SqlConnection con, 
            String dni, Int32 zona, Int32 local, Int32 area, Int32 cargo, Int32 turno, Int32 flex, Int32 remoto, Int32 marcacion, Int32 venta, String user)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_INDICADORPERSONAL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@zona", SqlDbType.Int).Value = zona;
            cmd.Parameters.AddWithValue("@local", SqlDbType.Int).Value = local;
            cmd.Parameters.AddWithValue("@area", SqlDbType.Int).Value = area;
            cmd.Parameters.AddWithValue("@cargo", SqlDbType.Int).Value = cargo;
            cmd.Parameters.AddWithValue("@turno", SqlDbType.Int).Value = turno;
            cmd.Parameters.AddWithValue("@flex", SqlDbType.Int).Value = flex;
            cmd.Parameters.AddWithValue("@remoto", SqlDbType.Int).Value = remoto;
            cmd.Parameters.AddWithValue("@marcacion", SqlDbType.Int).Value = marcacion;
            cmd.Parameters.AddWithValue("@venta", SqlDbType.Int).Value = venta;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;

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