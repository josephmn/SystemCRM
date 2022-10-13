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
    public class CMantLocal
    {
        public List<EMantenimiento> MantLocal(SqlConnection con, Int32 id, Int32 local, String nombre, Int32 zona, Int32 estado, String abrev, String user, String hinicio, String hfin, String htolerancia, Int32 tipoasistencia)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_LOCAL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@local", SqlDbType.Int).Value = local;
            cmd.Parameters.AddWithValue("@nombre", SqlDbType.VarChar).Value = nombre;
            cmd.Parameters.AddWithValue("@zona", SqlDbType.Int).Value = zona;
            cmd.Parameters.AddWithValue("@estado", SqlDbType.Int).Value = estado;
            cmd.Parameters.AddWithValue("@abrev", SqlDbType.VarChar).Value = abrev;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;
            cmd.Parameters.AddWithValue("@hinicio", SqlDbType.VarChar).Value = hinicio;
            cmd.Parameters.AddWithValue("@hfin", SqlDbType.VarChar).Value = hfin;
            cmd.Parameters.AddWithValue("@htolerancia", SqlDbType.VarChar).Value = htolerancia;
            cmd.Parameters.AddWithValue("@tipoasistencia", SqlDbType.VarChar).Value = tipoasistencia;

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